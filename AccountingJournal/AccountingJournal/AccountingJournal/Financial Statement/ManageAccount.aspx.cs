using AccountingJournal.Code;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Web;
using System.Web.Services;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Financial_Statement
{
    public partial class InActiveAccount : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Bind_Data();
            }            
        }
        private void Bind_Data()
        {
            DataTable ManAcc = Connection.ManageAccDisplay();
            GridView1.DataSource = ManAcc;
            GridView1.DataBind();
            for (int i = 0; i < GridView1.Rows.Count; i++)
            {
                CheckBox chk = GridView1.Rows[i].FindControl("chkStatus") as CheckBox;
                if (Convert.ToDouble(GridView1.Rows[i].Cells[4].Text) != 0 && chk.Checked == true)
                {
                    chk.Attributes.Add("onclick", "if(!confirm('The Balance is not 0. Do you want to Deactivate it?')) {return false};");
                    chk.Attributes.Add("OnCheckedChanged", "chkStatus_OnCheckedChanged");
                    chk.Attributes.Add("AutoPostBack", "True");
                    chk.Attributes.Add("Checked", "<%# Convert.ToBoolean(Eval('IsActive')) %>");
                }
                else
                {
                    chk.Attributes.Add("onclick", "if(!confirm('Do you want to Activate/Deactivate it?')){return false};;");
                    chk.Attributes.Add("OnCheckedChanged", "chkStatus_OnCheckedChanged");
                    chk.Attributes.Add("AutoPostBack", "True");
                    chk.Attributes.Add("Checked", "<%# Convert.ToBoolean(Eval('IsActive')) %>");
                }
            }
        }

        [WebMethod]
        public void chkStatus_OnCheckedChanged(object sender, EventArgs e)
        {
            CheckBox chkStatus = (CheckBox)sender;
            int nID = Convert.ToInt32(GridView1.DataKeys[((GridViewRow)chkStatus.NamingContainer).RowIndex].Value);
            try
            {
                Connection.UpdateActiveAcc(nID, chkStatus.Checked);
            }
            catch (Exception)
            {
                ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Activation Unsucessfully');", true);
            }
            finally
            {
                if (chkStatus.Checked == true)
                {
                    ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully Activate the Account');", true);
                }
                else
                {
                    ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully Deactivate the Account');", true);
                }
            }
            Bind_Data();
        }
    }
}