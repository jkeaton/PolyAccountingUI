using AccountingJournal.Code;
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
            //if (Session["userid"] == null)
            //{
            //    HttpCookie cookie = Request.Cookies["UserInfo"];

            //    if (cookie != null)
            //    {
            //        int id = Int32.Parse(cookie["uid"]);
            //        User user = Connection.GetUserByID(id);
            //        Session["userid"] = user.ID;
            //        Session["username"] = user.Username;
            //        Session["usertype"] = user.UserType;
            //        Session["isdisable"] = user.isDisabled;
            //    }
            //    else
            //    {
            //        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
            //    }
            //    if (Int32.Parse(Session["isdisable"].ToString()) == 1)
            //    {
            //        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
            //    }
            //    welcome_msg.Text = "Welcome " + Session["username"].ToString();
            //}
            //else
            //{
            //    if (Session["userid"] != null)
            //    {
            //        welcome_msg.Text = "Welcome " + Session["username"].ToString();
            //    }
            //    else
            //    {

            //            int id = Int32.Parse(Session["userid"].ToString());
            //            User user = Connection.GetUserByID(id);
            //            Session["userid"] = user.ID;
            //            Session["username"] = user.Username;
            //            Session["usertype"] = user.UserType;
            //            Session["isdisable"] = user.isDisabled;

            //        if (Int32.Parse(Session["isdisable"].ToString()) == 1)
            //        {
            //            Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
            //        }
            //        welcome_msg.Text = "Welcome " + Session["username"].ToString();
            //    }
            //}
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