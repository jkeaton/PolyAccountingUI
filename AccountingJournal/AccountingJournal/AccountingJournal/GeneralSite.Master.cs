using AccountingJournal.Code;
using System;
using System.Collections.Generic;
using System.Data;
using System.IO;
using System.Linq;
using System.Net.Mail;
using System.Net.Mime;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal
{
    public partial class Site1 : System.Web.UI.MasterPage
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
                    Session["pass"] = curr_user["Password"];
                }
                else
                {
                    Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                }
                if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
                {
                    Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                }
                welcome_msg.Text = "Welcome " + Session["username"].ToString() + "/"+ Session["pass"].ToString();
            }
            else
            {
                if (Session["userid"] != null)
                {
                    welcome_msg.Text = "Welcome " + Session["username"].ToString() + "/" + Session["pass"].ToString();
                }
                else
                {
                    Session["userid"] = curr_user["ID"];
                    Session["username"] = curr_user["UserName"];
                    Session["usertype"] = Int32.Parse(curr_user["UType"]);
                    Session["isdisabled"] = Int32.Parse(curr_user["IsLoginDisabled"]);

                    if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
                    {
                        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                    }
                    welcome_msg.Text = "Welcome " + Session["username"].ToString() + "/" + Session["pass"].ToString();
                }
            }
        }
        private bool IsValid(string emailaddress)
        {
            try
            {
                MailAddress m = new MailAddress(emailaddress);

                return true;
            }
            catch (FormatException)
            {
                return false;
            }
        }

        protected void logout_Click(object sender, EventArgs e)
        {
            Response.Cookies["UserCookie"].Expires = DateTime.Now.AddDays(-1);
            Session.Clear();
            Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
        }

        /*
        protected void SendEmail_Click(object sender, EventArgs e)
        {
            if (!IsValid(Receipients.Text))
            {
                SendEmailMess.Text = "Invalid Email Address.";
            }
            else
            {
                MailMessage mail = new MailMessage();
                mail.From = new MailAddress("polyaccinfo15@gmail.com");
                mail.To.Add(Receipients.Text);

                if (UpladAtt.HasFile)
                {
                    string FileName = Path.GetFileName(UpladAtt.PostedFile.FileName);
                    System.Net.Mail.Attachment attachment = new System.Net.Mail.Attachment(UpladAtt.PostedFile.InputStream, FileName);
                    mail.Attachments.Add(attachment);
                }
                mail.Subject = "Attachment Email Message";
                mail.Body = EmailBody.Text;

                SmtpClient smtp = new SmtpClient("smtp.gmail.com", 587);
                smtp.EnableSsl = true;
                smtp.Timeout = 10000;
                smtp.UseDefaultCredentials = false;
                smtp.Credentials = new System.Net.NetworkCredential("polyaccinfo15@gmail.com", "AccountUSER");
                smtp.Send(mail);
                SendEmailMess.Text = "Email was sent successfully.";
            }
        }
        */
    }
}