using AccountingJournal.Code;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal
{
    public partial class AdminSite : System.Web.UI.MasterPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            var request = HttpContext.Current.Request;
            var user_cookie = request.Cookies["UserCookie"];
            if (user_cookie == null)
            {
                Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
            }
            Dictionary<string, string> curr_user = Connection.GetUserInfo();
            if (Session["userid"] == null)
            {
                if (curr_user != null)
                {
                    Session["userid"] = curr_user["ID"];
                    Session["username"] = curr_user["UserName"];
                    Session["usertype"] = Int32.Parse(curr_user["UType"]);
                    Session["isdisabled"] = Int32.Parse(curr_user["IsLoginDisabled"]);
                }
                else
                {
                    Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                }
                if (Int32.Parse(Session["usertype"].ToString()) != 3)
                {
                    Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                }
                else if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
                {
                    Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                }
                welcome_msg.Text = "Welcome " + Session["username"].ToString();
            }
            else
            {
                if (Session["userid"] != null)
                {
                    welcome_msg.Text = "Welcome " + Session["username"].ToString();
                }
                else
                {
                    Session["userid"] = curr_user["ID"];
                    Session["username"] = curr_user["UserName"];
                    Session["usertype"] = Int32.Parse(curr_user["UType"]);
                    Session["isdisabled"] = Int32.Parse(curr_user["IsLoginDisabled"]);
                    if (Int32.Parse(Session["usertype"].ToString()) != 3)
                    {
                        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                    }
                    else if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
                    {
                        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                    }
                    welcome_msg.Text = "Welcome " + Session["username"].ToString();
                }
            }
        }
        protected void logout_Click(object sender, EventArgs e)
        {
            Response.Cookies["UserCookie"].Expires = DateTime.Now.AddDays(-1);
            Session.Clear();
            Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
        }

    }
}