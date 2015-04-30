using AccountingJournal.Code;
using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.ManageAccount
{
    public partial class NewAccount : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }
        int id;
        protected void Create_Click(object sender, EventArgs e)
        {
            int n;
            if (AccountNumber.Text == "")
            {
                AccountNumber.BackColor = Color.FromName("#ff9999");
                Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Please Enter Account Number');", true);
            }
            else if (!Int32.TryParse(AccountNumber.Text, out n))
            {
                AccountNumber.BackColor = Color.FromName("#ff9999");
                Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Invalid Account Number');", true);
            }
            else if (Connection.numofAcc(Int32.Parse(AccountNumber.Text)) > 0)
            {
                AccountNumber.BackColor = Color.FromName("#ff9999");
                Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Account Number already exists');", true);
            }
            else if (Acc_Name.Text == "")
            {
                Acc_Name.BackColor = Color.FromName("#ff9999");
                AccountNumber.BackColor = Color.White;
                Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Please Enter Name of Account');", true);
            }
            else if (Connection.numofAccbyname(Acc_Name.Text) > 0)
            {
                Acc_Name.BackColor = Color.FromName("#ff9999");
                AccountNumber.BackColor = Color.White;
                Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Account name already exists');", true);
            }
            else
            {
                Acc_Name.BackColor = Color.White;
                AccountNumber.BackColor = Color.White;
                HttpCookie cookie = Request.Cookies["UserCookie"];

                if (cookie != null)
                {
                    id = Int32.Parse(cookie.Value);
                }
                else
                {
                    id = 1;
                }
                int result = Connection.CreateAcc(Int32.Parse(AccountNumber.Text), Acc_Name.Text, Description.Text, Int32.Parse(Acc_Type.SelectedValue), Int32.Parse(NorBal.SelectedValue), Int32.Parse(Acc_Class.SelectedValue), DateTime.Now, id);
                if (result == 1)
                {
                    Page.ClientScript.RegisterStartupScript(GetType(), "msgbox", "alert('Account is created successfully');", true);
                    Response.Redirect(Request.RawUrl.ToString());
                }
            }
        }

      
    }
}