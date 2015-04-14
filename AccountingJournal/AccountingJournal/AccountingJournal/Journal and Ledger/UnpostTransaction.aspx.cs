using AccountingJournal.Code;
using AccountingJournal.Journal_and_Ledger.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.Services;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Journal_and_Ledger
{
    public partial class UnpostTransaction : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DisplayUnpostTranx();
            //if (!IsPostBack)
            //{
            //    Bind_Data();
            //}
        }

        private void Bind_Data()
        {
            Table Journal = Page.FindControl("Jourtab") as Table; 
            for (int i = 0; i < Journal.Rows.Count; i++)
            {
                Button btn = Journal.Rows[i].FindControl("Postbtn") as Button;
                
                    btn.Attributes.Add("OnClientClick", "if(!confirm('Do you want to post it?')){return false};;");
                    btn.Attributes.Add("onclick", "Postbtn_ServerClick");
                    btn.Attributes.Add("AutoPostBack", "True");
                
            }
        }


        private void DisplayUnpostTranx()
        {
            List<IndiJournal> unpost = Connection.DisplayUnpostTranx().Cast<IndiJournal>().ToList();
            StringBuilder sb = new StringBuilder();
            List<int> id = new List<int>();
            List<JourHeader> Journalheader = new List<JourHeader>();
            List<JourLine> JournalLine = new List<JourLine>();
            List<JourDesc> JournalDes = new List<JourDesc>();
            foreach (IndiJournal j in unpost)
            {
                if (!id.Contains(j.TranxID))
                {
                    id.Add(j.TranxID);

                }
                JourHeader newJournal = new JourHeader(j.TranxID, j.date, j.postdate, j.TotalAccEff);
                if (!Journalheader.Contains(newJournal))
                {
                    Journalheader.Add(newJournal);
                }
                if (!JournalLine.Contains(new JourLine(j.TranxID, j.Account, j.AccNum, j.Debit, j.Credit, j.IsDebit)))
                {
                    JournalLine.Add(new JourLine(j.TranxID, j.Account, j.AccNum, j.Debit, j.Credit, j.IsDebit));
                }

                if (!JournalDes.Contains(new JourDesc(j.TranxID, j.Desc)))
                {
                    JournalDes.Add(new JourDesc(j.TranxID, j.Desc));
                }

            }
            for (int i = 0; i < Journalheader.Count; i++)
            {
                int reset = 0;
                for (int j = 0; j < JournalLine.Count; j++)
                {
                    if (Journalheader[i].id == JournalLine[j].id)
                    {
                        if (reset == 0)
                        {
                            reset = 1;
                            sb.Append(string.Format(@"<tr>"));

                            sb.Append(string.Format(@"<td class='text-center' rowspan='{1}'>{0}</td>", Journalheader[i].Date.ToShortDateString(), Journalheader[i].TotalAccEff + 1));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none;color:black'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px;color:black'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='color:black'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'><button id='Postbtn' class='btn btn-primary form-control' runat='server' onserverclick='Postbtn_ServerClick'>Post</button><br/><br /><button id='Rejectedbtn' class='btn btn-danger form-control' runat='server' onserverclick='testbtn_ServerClick'>Reject</button></td>", Journalheader[i].id, Journalheader[i].TotalAccEff + 1));
                            sb.Append(string.Format(@"</tr>"));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none;color:black'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px;color:black'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='color:black'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"</tr>"));
                        }
                    }
                }
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td class='text-center'>"));
                for (int j = 0; j < JournalDes.Count; j++)
                {
                    if (Journalheader[i].id == JournalDes[j].id)
                    {
                        sb.Append(string.Format(@"<div>({0})</div>", JournalDes[j].Desc));
                    }
                }
                sb.Append(string.Format(@"</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
            }
            UnpostJour.Text = sb.ToString();
        }

        protected void testbtn_ServerClick(object sender, EventArgs e)
        {

            ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully Activate the Account');", true);
        }
              
        protected void Postbtn_ServerClick(object sender, EventArgs e)
        {
            ScriptManager.RegisterStartupScript(this, GetType(), "alertMessage", "alert('Sucessfully call post function');", true);
        }
    }
}
