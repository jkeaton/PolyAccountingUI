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
    public partial class RejectedTransaction : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            RejectedTranx();
        }

        private void RejectedTranx()
        {
            List<RejectedTranx> Rejected = Connection.DisplayRejectedTranx().Cast<RejectedTranx>().ToList();
            StringBuilder sb = new StringBuilder();
            List<int> id = new List<int>();
            List<RejectedHeader> Journalheader = new List<RejectedHeader>();
            List<JourLine> JournalLine = new List<JourLine>();
            List<JourDesc> JournalDes = new List<JourDesc>();
            foreach (RejectedTranx rejtranx in Rejected)
            {
                if (!id.Contains(rejtranx.TranxID))
                {
                    id.Add(rejtranx.TranxID);
                }
                RejectedHeader newJournal = new RejectedHeader(rejtranx.TranxID, rejtranx.date, rejtranx.RejectedUser, rejtranx.TotalAccEff);
                if (!Journalheader.Contains(newJournal))
                {
                    Journalheader.Add(newJournal);
                }
                if (!JournalLine.Contains(new JourLine(rejtranx.TranxID, rejtranx.Account, rejtranx.AccNum, rejtranx.Debit, rejtranx.Credit, rejtranx.IsDebit)))
                {
                    JournalLine.Add(new JourLine(rejtranx.TranxID, rejtranx.Account, rejtranx.AccNum, rejtranx.Debit, rejtranx.Credit, rejtranx.IsDebit));
                }

                if (!JournalDes.Contains(new JourDesc(rejtranx.TranxID, rejtranx.Desc)))
                {
                    JournalDes.Add(new JourDesc(rejtranx.TranxID, rejtranx.Desc));
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
                            sb.Append(string.Format(@"<td class='text-center' rowspan='{1}'>{0}</td>", Journalheader[i].Date.ToShortDateString(), Journalheader[i].TotalAccEff+1));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'>{0}</td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left><div style='margin-left:20px'>{0}</div></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'>{0}</td>", Journalheader[i].RejectedUser, Journalheader[i].TotalAccEff+1));
                            sb.Append(string.Format(@"</tr>"));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'>{0}</td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><div style='margin-left:20px'>{0}</div></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"</tr>"));
                        }
                    }
                }
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td>"));
                for (int j = 0; j < JournalDes.Count; j++)
                {
                    if (Journalheader[i].id == JournalDes[j].id)
                    {
                        if (JournalDes[j].Desc == "")
                        {
                            sb.Append(string.Format(@"<p style='text-decoration:none; margin-left:40px;'>{0}</p>", JournalDes[j].Desc));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<p style='text-decoration:none; margin-left:40px;'>({0})</p>", JournalDes[j].Desc));
                        }
                    }
                }
                sb.Append(string.Format(@"</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
            }
            RejTranx.Text = sb.ToString();
        }
        DateTime start, end;
        List<RejectedTranx> Rej = new List<RejectedTranx>();
        protected void Search_Click(object sender, EventArgs e)
        {
            if (Price.Text == "")
            {
                string acc = accname.Text;
                if (StartDate.Text == "")
                {
                    start = DateTime.Parse("1/1/1900");
                }
                else
                {
                    start = DateTime.Parse(StartDate.Text);
                }
                if (Enddate.Text == "")
                {
                    end = DateTime.Parse("1/1/9999");
                }
                else
                {
                    end = DateTime.Parse(Enddate.Text);
                }

                Rej = Connection.SearchRejectedEntry(start,end, acc).Cast<RejectedTranx>().ToList();
            }
            else
            {
                string acc = accname.Text;
                double price = double.Parse(Price.Text);
                if (StartDate.Text == "")
                {
                    start = DateTime.Parse("1/1/1900");
                }
                else
                {
                    start = DateTime.Parse(StartDate.Text);
                }
                if (Enddate.Text == "")
                {
                    end = DateTime.Parse("1/1/9999");
                }
                else
                {
                    end = DateTime.Parse(Enddate.Text);
                }

                Rej = Connection.SearchRejectedEntryWithPrice(start, end, acc, price).Cast<RejectedTranx>().ToList();
            }

            
            StringBuilder sb = new StringBuilder();
            List<int> id = new List<int>();
            List<RejectedHeader> Journalheader = new List<RejectedHeader>();
            List<JourLine> JournalLine = new List<JourLine>();
            List<JourDesc> JournalDes = new List<JourDesc>();
            foreach (RejectedTranx rejtranx in Rej)
            {
                if (!id.Contains(rejtranx.TranxID))
                {
                    id.Add(rejtranx.TranxID);
                }
                RejectedHeader newJournal = new RejectedHeader(rejtranx.TranxID, rejtranx.date, rejtranx.RejectedUser, rejtranx.TotalAccEff);
                if (!Journalheader.Contains(newJournal))
                {
                    Journalheader.Add(newJournal);
                }
                if (!JournalLine.Contains(new JourLine(rejtranx.TranxID, rejtranx.Account, rejtranx.AccNum, rejtranx.Debit, rejtranx.Credit, rejtranx.IsDebit)))
                {
                    JournalLine.Add(new JourLine(rejtranx.TranxID, rejtranx.Account, rejtranx.AccNum, rejtranx.Debit, rejtranx.Credit, rejtranx.IsDebit));
                }

                if (!JournalDes.Contains(new JourDesc(rejtranx.TranxID, rejtranx.Desc)))
                {
                    JournalDes.Add(new JourDesc(rejtranx.TranxID, rejtranx.Desc));
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
                                sb.Append(string.Format(@"<td style='text-align:left'>{0}</td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left><div style='margin-left:20px'>{0}</div></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'>{0}</td>", Journalheader[i].RejectedUser, Journalheader[i].TotalAccEff + 1));
                            sb.Append(string.Format(@"</tr>"));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'>{0}</td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><div style='margin-left:20px'>{0}</div></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"</tr>"));
                        }
                    }
                }
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td>"));
                for (int j = 0; j < JournalDes.Count; j++)
                {
                    if (Journalheader[i].id == JournalDes[j].id)
                    {
                        if (JournalDes[j].Desc == "")
                        {
                            sb.Append(string.Format(@"<p style='text-decoration:none; margin-left:40px;'>{0}</p>", JournalDes[j].Desc));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<p style='text-decoration:none; margin-left:40px;'>({0})</p>", JournalDes[j].Desc));
                        }
                    }
                }
                sb.Append(string.Format(@"</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
            }
            RejTranx.Text = sb.ToString();
        }

    }
}
