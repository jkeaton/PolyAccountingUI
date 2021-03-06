﻿using AccountingJournal.Code;
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
            List<JourHeader> Journalheader = new List<JourHeader>();
            List<JourLine> JournalLine = new List<JourLine>();
            List<JourDesc> JournalDes = new List<JourDesc>();
            foreach (IndiJournal j in Jour)
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
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'>{0}</td>", Journalheader[i].PostDate != null ? Journalheader[i].PostDate.Value.ToString("MM/dd/yyy") : "", Journalheader[i].TotalAccEff + 1));
                            sb.Append(string.Format(@"</tr>"));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
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
            IndJour.Text = sb.ToString();
        }
        DateTime start, end;
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

                Jour = Connection.SearchJournalEntry(start, end, acc).Cast<IndiJournal>().ToList();
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

                Jour = Connection.SearchJournalEntryWithPrice(start, end, acc, price).Cast<IndiJournal>().ToList();
            }
            StringBuilder sb = new StringBuilder();
            List<int> id = new List<int>();
            List<JourHeader> Journalheader = new List<JourHeader>();
            List<JourLine> JournalLine = new List<JourLine>();
            List<JourDesc> JournalDes = new List<JourDesc>();
            foreach (IndiJournal j in Jour)
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
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'>{0}</td>", Journalheader[i].PostDate != null ? Journalheader[i].PostDate.Value.ToString("MM/dd/yyy") : "", Journalheader[i].TotalAccEff + 1));
                            sb.Append(string.Format(@"</tr>"));
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            if (JournalLine[j].IsDebit == "Debit")
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            else
                            {
                                sb.Append(string.Format(@"<td style='text-align:left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            }
                            sb.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
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
            IndJour.Text = sb.ToString();
        }
    }
}