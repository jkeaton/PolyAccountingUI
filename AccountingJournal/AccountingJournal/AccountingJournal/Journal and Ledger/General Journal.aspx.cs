using AccountingJournal.Code;
using AccountingJournal.Journal_and_Ledger.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Journal_and_Ledger
{
    public partial class General_Journal : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DisplayJournal();
        }
        List<IndiJournal> Jour = new List<IndiJournal>();
        private void DisplayJournal()
        {
            if (Request.QueryString["Accnum"] != null)
            {
                Jour = Connection.DisplayIndiJournal(Request.QueryString["Accnum"]).Cast<IndiJournal>().ToList();
                filter.Visible = false;
            }
            else
            {
                Jour = Connection.DisplayJournal().Cast<IndiJournal>().ToList();
            }
            StringBuilder sb = new StringBuilder();
            List<int> id = new List<int>();
            foreach (IndiJournal j in Jour)
            {
                id.Add(j.TranxID);
            }
            foreach (IndiJournal j in Jour)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td>{0}</td>", j.date.ToShortDateString()));
                if (j.IsDebit == "Debit")
                {
                    sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none;color:black'>{0}</a></td>", j.Account, j.AccNum));
                }
                else
                {
                    sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px;color:black'>{0}</a></td>", j.Account, j.AccNum));
                }
                sb.Append(string.Format(@"<td>{0}</td>",j.postdate != null? j.postdate.Value.ToString("MM/dd/yyy"):""));
                sb.Append(string.Format(@"<td><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='color:black'>{0}</a></td>", j.AccNum, j.AccNum));
                sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", string.Format("{0:#,##0.00}", j.Debit)));
                sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", string.Format("{0:#,##0.00}", j.Credit)));
                sb.Append(string.Format(@"</tr>"));
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td style='height:50px;'>"));
                sb.Append(string.Format(@"{0}", "(" + j.Desc + ")"));
                sb.Append(string.Format(@"</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
            }
            IndJour.Text = sb.ToString();            
        }
    }
}