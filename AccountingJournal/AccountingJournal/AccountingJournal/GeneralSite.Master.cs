using System;
using System.Collections.Generic;
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

        }
        /*
        public void LoadPage()
        {
            HttpCookie cookie = Request.Cookies["UserInfo"];
            if (cookie != null)
            {
                if (cookie["id"] != null)
                {
                    if (cookie["FirstName"] == null)
                        SignInLb.Text = "Welcome, <a href='../Account/ManageAccount.aspx'>" + cookie["Username"] + "<a>";
                    else
                        SignInLb.Text = "Welcome, <a href='../Account/ManageAccount.aspx'>" + (cookie["FirstName"] + " " + cookie["LastName"]) + "<a>";
                    SignInLb.Visible = true;
                    SignInLkB.Text = "(SignOut)";
                }
                else
                {
                    SignInLb.Visible = false;
                    SignInLkB.Text = "(SignIn)";
                }
            }
            else
            {
                SignInLb.Visible = false;
                SignInLkB.Text = "(SignIn)";
            }
        }*/

        /*
        protected void SignInLkB_Click(object sender, EventArgs e)
        {
            HttpCookie cookie = Request.Cookies["UserInfo"];
            if (cookie != null)
            {
                if (cookie["id"] == null)
                {
                    SignInLb.Text = "";
                    SignInLb.Visible = false;
                    Response.Redirect("~/SignIn/Login.aspx");
                }
                else
                {
                    cookie = Request.Cookies["UserInfo"];
                    Response.Cookies.Remove("UserInfo");
                    cookie.Value = null;
                    Response.SetCookie(cookie);
                    SignInLb.Text = "";
                    SignInLb.Visible = false;
                    SignInLkB.Text = "(LogIn)";

                }
            }
            else
            {
                SignInLb.Text = "";
                SignInLb.Visible = false;
                Response.Redirect("~/SignIn/Login.aspx");
            }
        }
        */
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