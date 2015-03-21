using AccountingJournal.Code;
using AccountingJournal.Journal_and_Ledger.Model;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using AccountingJournal.Journal_and_Ledger;
using System.Text;

namespace AccountingJournal.Journal_and_Legend
{
    public partial class General_Ledger : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            LoadGeneralLedger();
        }

        private void LoadGeneralLedger()
        {
            string id = Request.QueryString["ID"];
            List<Ledger> LedgerList = Connection.DisplayGenLedger(id).Cast<Ledger>().ToList();
            StringBuilder sb = new StringBuilder();
            string Acc = "";
            foreach (Ledger l in LedgerList)
            {
                Acc = l.Account;
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td>{0}</td>", l.date.ToShortDateString()));
                sb.Append(string.Format(@"<td class='text-left'>{0}</td>", l.Description));
                sb.Append(string.Format(@"<td><a href='../Journal and Ledger/General Journal.aspx?Accnum={1}'>{0}</a></td>", l.Ref, l.TranxID));
                sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", l.Debit)));
                sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", l.Credit)));
                sb.Append(string.Format(@"<td class='text-right'>{0}</td>", l.Balance.ToString("#,##0.00")));
                sb.Append(string.Format(@"</tr>"));
            }
            GL_Detail.Text = sb.ToString();
            GL_Title.Text = Acc;
            GL_Number.Text = "NO. "+id;
        }
    }
}