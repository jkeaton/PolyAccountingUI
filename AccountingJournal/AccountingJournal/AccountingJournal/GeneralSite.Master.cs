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
                if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
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

                    if (Int32.Parse(Session["isdisabled"].ToString()) == 1)
                    {
                        Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
                    }
                    welcome_msg.Text = "Welcome " + Session["username"].ToString();
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
            Response.Cookies["userId"].Expires = DateTime.Now.AddDays(-1);
            Session.Clear();
            Response.Redirect("http://test-mesbrook.cloudapp.net/index.php");
        }
        protected void Butt0_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt0.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt0.Text;
            }
        }

        protected void Buttdot_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Buttdot.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Buttdot.Text;
            }
        }

        protected void Butt3_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt3.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt3.Text;
            }
        }

        protected void Butt4_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt4.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt4.Text;
            }
        }

        protected void Butt2_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt2.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt2.Text;
            }
        }

        protected void Butt1_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt1.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt1.Text;
            }
        }

        protected void Butt5_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt5.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt5.Text;
            }
        }

        protected void Butt6_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt6.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt6.Text;
            }
        }

        protected void Butt7_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt7.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt7.Text;
            }
        }

        protected void Butt8_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt8.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt8.Text;
            }
        }

        protected void Butt9_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Butt9.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Butt9.Text;
            }
        }

        protected void Plus_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Plus.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Plus.Text;
            }
        }

        protected void Subtr_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Subtr.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Subtr.Text;
            }
        }

        protected void Time_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Time.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Time.Text;
            }
        }

        protected void Divide_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += Divide.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += Divide.Text;
            }
        }

        protected void Clear_Click(object sender, EventArgs e)
        {
            Result.Text = "";
            Operation.Value = "CLR";
        }

        protected void Del_Click(object sender, EventArgs e)
        {
            string DisplayText = Result.Text;
            int LastIndex = DisplayText.Length;
            Result.Text = Result.Text.Remove(LastIndex - 1);    
        }

        protected void Buttequal_Click(object sender, EventArgs e)
        {
            try
            {
                string Input = Result.Text;
                DataTable table = new DataTable();
                Object answer;
                answer = table.Compute(Input, null);
                Result.Text = answer.ToString();
                Operation.Value = "=";
            }

            catch
            {
                Result.Text = "ERROR!";
            } 
        }

        protected void ButtLef_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += ButtLef.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += ButtLef.Text;
            }
        }

        protected void ButtRight_Click(object sender, EventArgs e)
        {
            if (Result.Text == "ERROR!" || Operation.Value == "CLR" || Operation.Value == "=")
            {
                Result.Text = "";
                Result.Text += ButtRight.Text;
                Operation.Value = "";
            }
            else
            {
                Result.Text += ButtRight.Text;
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