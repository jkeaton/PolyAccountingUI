﻿using AccountingJournal.Code;
using AccountingJournal.Journal_and_Ledger.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.HtmlControls;
using System.Web.UI.WebControls;

namespace AccountingJournal.Journal_and_Ledger
{
    public partial class UnpostTranx : System.Web.UI.Page
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
            TableRow tempRow = new TableRow();
            //Foreach Transaction
            for (int i = 0; i < Journalheader.Count; i++)
            {
                Boolean firstLine = true; // Tells us whether or not to add the date and Post/Reject buttons
                for (int j = 0; j < JournalLine.Count; j++)
                {
                    if (Journalheader[i].id == JournalLine[j].id)
                    {
                        tempRow = new TableRow();
                        if (JournalLine[j].IsDebit == "Debit" && firstLine == true)
                        {
                            TableCell date = new TableCell();
                            date.Text = Journalheader[i].Date.ToShortDateString();
                            date.Attributes.Add("rowspan", (Journalheader[i].TotalAccEff + 1).ToString());
                            tempRow.Cells.Add(date);

                            TableCell Accname = new TableCell();
                            //Accname.Text = JournalLine[j].Account;

                            LinkButton lbtn = new LinkButton();
                            lbtn.Attributes.Add("ID", "name");
                            lbtn.Text = JournalLine[j].Account;
                            lbtn.Click += new EventHandler(LinkButton1_Click);
                            Accname.Controls.Add(lbtn);
                            tempRow.Cells.Add(Accname);


                            TableCell Ref = new TableCell();
                            Ref.Attributes.Add("class", "text-right");
                            LinkButton reference = new LinkButton();
                            reference.Text = JournalLine[j].AccNum.ToString();
                            reference.Click += new EventHandler(Reference_Click);
                            Ref.Controls.Add(reference);
                            tempRow.Cells.Add(Ref);

                            TableCell Debit = new TableCell();
                            Debit.Attributes.Add("class", "text-right");
                            Debit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Debit);
                            tempRow.Cells.Add(Debit);


                            TableCell Credit = new TableCell();
                            Credit.Attributes.Add("class", "text-right");
                            Credit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Credit);
                            tempRow.Cells.Add(Credit);


                            TableCell Action = new TableCell();
                            Action.Attributes.Add("class", "text-center");
                            Button post = new Button();
                            post.Attributes.Add("class", "btn btn-primary");
                            post.Attributes.Add("style", "width:80px");
                            post.Text = "Post";
                            post.Click += new EventHandler(PostButton_Click);
                            Action.Controls.Add(post);
                            Button Reject = new Button();
                            Reject.Attributes.Add("class", "btn btn-danger");
                            Reject.Attributes.Add("style", "width:80px");
                            Reject.Text = "Reject";
                            Reject.Click += new EventHandler(RejectButton_Click);
                            Action.Controls.Add(Reject);
                            Action.Attributes.Add("rowspan", (Journalheader[i].TotalAccEff + 1).ToString());
                            tempRow.Cells.Add(Action);
                            firstLine = false;

                            TableCell jourid = new TableCell();
                            jourid.Text = Journalheader[i].id.ToString();
                            //jourid.Visible = false;
                            tempRow.Cells.Add(jourid);
                        }
                        else if (JournalLine[j].IsDebit == "Debit" && firstLine == false)
                        {

                            TableCell Accname = new TableCell();
                            LinkButton lbtn = new LinkButton();
                            lbtn.Text = JournalLine[j].Account;
                            lbtn.Attributes.Add("ID", "name");
                            lbtn.Click += new EventHandler(LinkButton1_Click);
                            Accname.Controls.Add(lbtn);
                            tempRow.Cells.Add(Accname);
                            TableCell Ref = new TableCell();
                            Ref.Attributes.Add("class", "text-right");
                            LinkButton reference = new LinkButton();                            
                            reference.Text = JournalLine[j].AccNum.ToString();
                            reference.Click += new EventHandler(Reference_Click);
                            Ref.Controls.Add(reference);
                            tempRow.Cells.Add(Ref);

                            TableCell Debit = new TableCell();
                            Debit.Attributes.Add("class", "text-right");
                            Debit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Debit);
                            tempRow.Cells.Add(Debit);


                            TableCell Credit = new TableCell();
                            Credit.Attributes.Add("class", "text-right");
                            Credit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Credit);
                            tempRow.Cells.Add(Credit);

                        }
                        else
                        {
                            TableCell Accname = new TableCell();
                            LinkButton lbtn = new LinkButton();
                            lbtn.Text = JournalLine[j].Account;
                            lbtn.Attributes.Add("ID", "name");
                            lbtn.Click += new EventHandler(LinkButton1_Click);
                             HtmlGenericControl div1 = new HtmlGenericControl("div");
                             div1.Controls.Add(lbtn);
                            div1.Attributes.Add("style", " margin-left:20px");
                            Accname.Controls.Add(div1);
                            tempRow.Cells.Add(Accname);
                            TableCell Ref = new TableCell();
                            Ref.Attributes.Add("class", "text-right");
                            LinkButton reference = new LinkButton();
                            reference.Text = JournalLine[j].AccNum.ToString();
                            reference.Click += new EventHandler(Reference_Click);
                            Ref.Controls.Add(reference);
                            tempRow.Cells.Add(Ref);

                            TableCell Debit = new TableCell();
                            Debit.Attributes.Add("class", "text-right");
                            Debit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Debit);
                            tempRow.Cells.Add(Debit);


                            TableCell Credit = new TableCell();
                            Credit.Attributes.Add("class", "text-right");
                            Credit.Text = string.Format("{0:#,##0.00}", JournalLine[j].Credit);
                            tempRow.Cells.Add(Credit);

                        }

                        Jourtab.Rows.Add(tempRow);
                    }
                }
                for (int j = 0; j < JournalDes.Count; j++)
                {
                    if (Journalheader[i].id == JournalDes[j].id)
                    {
                        tempRow = new TableRow();
                        HtmlGenericControl div1 = new HtmlGenericControl("div");
                        div1.InnerText = "(" + JournalDes[j].Desc + ")";
                        div1.Attributes.Add("style", " margin-left:40px");
                        TableCell Desc = new TableCell();
                        Desc.Controls.Add(div1);
                        tempRow.Cells.Add(Desc);
                        TableCell Ref = new TableCell();
                        tempRow.Cells.Add(Ref);

                        TableCell Debit = new TableCell();
                        tempRow.Cells.Add(Debit);


                        TableCell Credit = new TableCell();
                        tempRow.Cells.Add(Credit);
                        Jourtab.Rows.Add(tempRow);
                    }
                }
            }
        }

        private void RejectButton_Click(object sender, EventArgs e)
        {
            Button rejected = (Button)sender;
            TableRow row = rejected.Parent.Parent as TableRow;
            int jourid = Int32.Parse(row.Cells[6].Text);
            Connection.RejectTranx(jourid,"student", "Spsu20!4");
            DisplayUnpostTranx();
        }

        private void PostButton_Click(object sender, EventArgs e)
        {
            Button rejected = (Button)sender;
            TableRow row = rejected.Parent.Parent as TableRow;
            int jourid = Int32.Parse(row.Cells[6].Text);
            Connection.PostTranx(jourid, "student", "Spsu20!4");
            DisplayUnpostTranx();
        }

        private void Reference_Click(object sender, EventArgs e)
        {
            int accnum;
            LinkButton Reference = (LinkButton)sender;
            TableRow row = Reference.Parent.Parent as TableRow;
            if (row == null)
            {
                row = Reference.Parent.Parent.Parent as TableRow;
            }
            if (row.Cells.Count == 4)
            {
                LinkButton REF = row.Cells[1].Controls[0] as LinkButton;
                accnum = Int32.Parse(REF.Text);
            }
            else
            {
                LinkButton REF = row.Cells[2].Controls[0] as LinkButton;
                accnum = Int32.Parse(REF.Text);
            }
            Response.Redirect("../Journal and Ledger/General Ledger.aspx?ID=" + accnum);
        }

        private void LinkButton1_Click(object sender, EventArgs e)
        {
            //
            int accnum;
            LinkButton accname = (LinkButton)sender;
            TableRow row = accname.Parent.Parent as TableRow;
            if (row == null)
            {
                row = accname.Parent.Parent.Parent as TableRow;
            }
            if (row.Cells.Count ==4)
            {                
                LinkButton REF = row.Cells[1].Controls[0] as LinkButton;
                accnum = Int32.Parse(REF.Text);
            }
            else
            {
                LinkButton REF = row.Cells[2].Controls[0] as LinkButton;
                accnum = Int32.Parse(REF.Text);
            }
            Response.Redirect("../Journal and Ledger/General Ledger.aspx?ID=" + accnum);
        }
    }
}