using AccountingJournal.Code;
using AccountingJournal.Financial_Statement.Statement_Model;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Financial_Statement
{
    public partial class TrialBalance : System.Web.UI.Page
    {
        float totlDeb = 0;
        float totlCre = 0;
        protected void Page_Load(object sender, EventArgs e)
        {
            LoadTrialBalance();
        }

        private void LoadTrialBalance()
        {
            ArrayList tr = Connection.DisplayTrialBalance();
            StringBuilder sb = new StringBuilder();
            Boolean firstDr = false;
            Boolean firstCr = false;
            foreach (TrialBl Trial in tr)
            {
<<<<<<< HEAD
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td  class='text-left'>"));
                sb.Append(string.Format(@"<a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}<a>", Trial.Name, Trial.AccNum));
                sb.Append(string.Format(@"</td>"));
                if (Trial.IsDebit == "Debit")
=======
                if (Trial.Total > 0)
>>>>>>> a3260b11ebeaca1f46e876f78cf29aa45b272474
                {
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td  class='text-left'>"));
                    sb.Append(string.Format(@"<a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}<a>", Trial.Name, Trial.AccNum));
                    sb.Append(string.Format(@"</td>"));
                    if (Trial.IsDebit == "Debit")
                    {
                        if (!firstDr)
                        {
                            sb.Append(string.Format(@"<td style='text-align: Right'>"));
                            sb.Append(string.Format(@"$ {0}", Trial.Total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"</td>"));
                            sb.Append(string.Format(@"<td>"));
                            sb.Append(string.Format(@"</td>"));
                            firstDr = true;
                        }
                        else
                        {
                            sb.Append(string.Format(@"<td style='text-align: Right'>"));
                            sb.Append(string.Format(@"{0}", Trial.Total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"</td>"));
                            sb.Append(string.Format(@"<td>"));
                            sb.Append(string.Format(@"</td>"));
                        }

                        totlDeb += (float)Trial.Total;
                    }
                    else if (Trial.IsDebit == "Credit")
                    {
                        if (!firstCr)
                        {
                            sb.Append(string.Format(@"<td>"));
                            sb.Append(string.Format(@"</td>"));
                            sb.Append(string.Format(@"<td style='text-align: Right'>"));
                            sb.Append(string.Format(@"$ {0}", Trial.Total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"</td>"));
                            firstCr = true;
                        }
                        else
                        {
                            sb.Append(string.Format(@"<td>"));
                            sb.Append(string.Format(@"</td>"));
                            sb.Append(string.Format(@"<td style='text-align: Right'>"));
                            sb.Append(string.Format(@"{0}", Trial.Total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"</td>"));
                        }

                        totlCre += (float)Trial.Total;
                    }
                    sb.Append(string.Format(@"</tr>"));
                }
            }
            T_Balance.Text = sb.ToString();
<<<<<<< HEAD
            TotalCre.Text = "$ "+totlCre.ToString("#,##0.00");
            TotalDeb.Text = "$ "+totlDeb.ToString("#,##0.00");
=======
            TotalCre.Text = string.Format(@"$ {0}", totlCre.ToString("#,##0.00"));
            TotalDeb.Text = string.Format(@"$ {0}", totlDeb.ToString("#,##0.00"));
>>>>>>> a3260b11ebeaca1f46e876f78cf29aa45b272474
        }
    }
}