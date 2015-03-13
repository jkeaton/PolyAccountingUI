using AccountingJournal.Code;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Account
{
    public partial class WebForm1 : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void SigButt_Click(object sender, EventArgs e)
        {
            if (Connection.GetNumofUserByUsernameAndPassword(SigUname.Text, SigPass.Text) == 1)
            {
                ArrayList Userlist = Connection.GetUserByUsernameAndPassword(SigUname.Text, SigPass.Text);
                HttpCookie cookie = Request.Cookies["UserInfo"];
                if (cookie != null)
                {
                    foreach (User user in Userlist)
                    {
                        cookie["id"] = user.ID.ToString();
                        cookie["FirstName"] = user.FirstName;
                        cookie["LastName"] = user.LastName;
                        cookie["Username"] = user.Username;
                        cookie["Password"] = user.Password;
                        cookie["Email"] = user.Email;
                        cookie["Usertype"] = user.UserType;
                    }
                    Response.SetCookie(cookie);
                }
                else
                {
                    cookie = new HttpCookie("UserInfo");
                    foreach (User user in Userlist)
                    {
                        cookie["id"] = user.ID.ToString();
                        cookie["FirstName"] = user.FirstName;
                        cookie["LastName"] = user.LastName;
                        cookie["Username"] = user.Username;
                        cookie["Password"] = user.Password;
                        cookie["Email"] = user.Email;
                        cookie["Usertype"] = user.UserType;
                    }
                    Response.Cookies.Add(cookie);
                }
                if (cookie["Usertype"] == "Administrator")
                {
                    Response.Redirect("~/Administrator/AdminHome.aspx");
                }
                else if (cookie["Usertype"] == "Manger")
                {
                    Response.Redirect("~/Manager/ManagerHome.aspx");
                }
                else
                {
                    Response.Redirect("~/GeneralAccounter/AccounterHome.aspx");
                }
            }
            else
            {
                SigMess.Text = "Sorry, that userame and password combination does not exist.<br/>Please ensure your username and password have been entered correctly.";
            }
        }

        protected void Regis_Click(object sender, EventArgs e)
        {
            Response.Redirect("~/Account/Register.aspx");
        }

        protected void FgPass_Click(object sender, EventArgs e)
        {
            Response.Redirect("~/Account/ForgetPassword.aspx");
        }
    }
}