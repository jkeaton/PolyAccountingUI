﻿using AccountingJournal.Code;
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
                int totaltranx = Connection.numofTranx(Int32.Parse(GridView1.Rows[i].Cells[2].Text));
                if ((Convert.ToDouble(GridView1.Rows[i].Cells[4].Text) != 0 ||totaltranx >0 ) && chk.Checked == true)
                {
                    chk.Attributes.Add("onclick", "alert('The Account is being used.');");
                    //chk.Attributes.Add("OnCheckedChanged", "chkStatus_OnCheckedChanged");
                    //chk.Attributes.Add("AutoPostBack", "True");
                    chk.Attributes.Add("Checked", "<%# Convert.ToBoolean(Eval('IsActive')) %>");
                }
                else if (Convert.ToDouble(GridView1.Rows[i].Cells[4].Text) == 0 && totaltranx==0 && chk.Checked == true)
                {
                    chk.Attributes.Add("onclick", "if(!confirm('Do you want to Deactivate it?')){return false};;");
                    chk.Attributes.Add("OnCheckedChanged", "chkStatus_OnCheckedChanged");
                    chk.Attributes.Add("AutoPostBack", "True");
                    chk.Attributes.Add("Checked", "<%# Convert.ToBoolean(Eval('IsActive')) %>");
                }
                else if (Convert.ToDouble(GridView1.Rows[i].Cells[4].Text) == 0 && totaltranx==0 && chk.Checked == false)
                {
                    chk.Attributes.Add("onclick", "if(!confirm('Do you want to Activate it?')){return false};;");
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
            int totaltransaction = Connection.numofTranxbyid(nID);
            double balance = (double)Connection.BalanceofTranxbyid(nID);
            if (balance == 0 && totaltransaction == 0)
            {
                try
                {
                    Connection.UpdateActiveAcc(nID, chkStatus.Checked);
                    if (chkStatus.Checked == true)
                    {
                        ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully Activate the Account');", true);
                    }
                    else
                    {
                        ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully Deactivate the Account');", true);
                    }
                    Bind_Data();
                }

                catch (Exception ex)
                {
                    //ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('The Account needs to be 0.00 in order to deactivate');", true);
                    Bind_Data();
                }
            }
            else
            {
                Bind_Data();
            }
        }
    }
}