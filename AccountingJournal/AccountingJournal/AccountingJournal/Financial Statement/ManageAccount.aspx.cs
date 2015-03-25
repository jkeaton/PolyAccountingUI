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