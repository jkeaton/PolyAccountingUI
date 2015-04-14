<<<<<<< HEAD
﻿using AccountingJournal.Code;
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
=======
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
    public partial class UnpostTransaction : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DisplayUnpostTranx();
        }


        private void DisplayUnpostTranx()
        {
            List<IndiJournal> unpost = Connection.DisplayUnpostTranx().Cast<IndiJournal>().ToList();
            List<String> dr_html = new List<String>();
            List<String> cr_html = new List<String>();
            StringBuilder sb = new StringBuilder();
            StringBuilder sb_dr = new StringBuilder();
            StringBuilder sb_cr = new StringBuilder();
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
            // For each transaction
            for (int i = 0; i < Journalheader.Count; i++) {
                // First create each row's string and place that string in the correct list
                dr_html.Clear();
                cr_html.Clear();
                for (int j = 0; j < JournalLine.Count; j++) {
                    if (Journalheader[i].id == JournalLine[j].id) {
                        if (JournalLine[j].IsDebit == "Debit"){
                            sb_dr.Clear();
                            sb_dr.Append(string.Format(@"<td style='text-align:left'><a class='link' href='../Journal and Ledger/General Ledger.aspx?ID={1}'style='text-decoration:none;'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            sb_dr.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb_dr.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb_dr.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            dr_html.Add(sb_dr.ToString());
                        }
                        else {
                            sb_cr.Clear();
                            sb_cr.Append(string.Format(@"<td style='text-align:left'><a class='link' href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; margin-left:20px;'>{0}</a></td>", JournalLine[j].Account, JournalLine[j].AccNum));
                            sb_cr.Append(string.Format(@"<td class='text-right'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}'>{0}</a></td>", JournalLine[j].AccNum, JournalLine[j].AccNum));
                            sb_cr.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Debit)));
                            sb_cr.Append(string.Format(@"<td class='text-right'>{0}</td>", string.Format("{0:#,##0.00}", JournalLine[j].Credit)));
                            cr_html.Add(sb_cr.ToString());
                        }
                    }
                }
                Boolean firstLine = true; // Tells us whether or not to add the date and Post/Reject buttons
                // First handle adding the debit rows
                foreach (String s in dr_html)
                {
                    if (firstLine)
                    {
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(string.Format(@"<td class='text-center' rowspan='{1}'>{0}</td>", Journalheader[i].Date.ToShortDateString(), Journalheader[i].TotalAccEff + 1));
                        sb.Append(s);
                        sb.Append(string.Format(@"<td class='text-center vcenter' rowspan='{1}'><button class='btn btn-primary form-control' value='{0}'>Post</button><br/><br /><button class='btn btn-danger form-control' value'{0}'>Reject</button></td>", Journalheader[i].id, Journalheader[i].TotalAccEff + 1));
                        sb.Append(string.Format(@"</tr>"));
                        firstLine = false;
                    }
                    else
                    {
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(s);
                        sb.Append(string.Format(@"</tr>"));
                    }
                }
                // Now handle adding the credit rows
                foreach (String s in cr_html)
                {
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(s);
                    sb.Append(string.Format(@"</tr>"));
                }
                // Add the description row below all the debits and credits
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td>"));
                for (int j = 0; j < JournalDes.Count; j++)
                {
                    if (Journalheader[i].id == JournalDes[j].id)
                    {
                        sb.Append(string.Format(@"<div style='margin-left:40px;'>({0})</div>", JournalDes[j].Desc));
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
    }
}
>>>>>>> b4fc1581393ed780d6d4bba029f85653d4e6c936
