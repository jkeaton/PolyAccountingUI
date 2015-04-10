using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.HtmlControls;
using System.Web.UI.WebControls;

namespace AccountingJournal
{       
    public partial class journalentry : System.Web.UI.Page
    {
        DataTable Debtbl = new DataTable();
        DataTable Cretbl = new DataTable();
        protected void Page_Load(object sender, EventArgs e)
        {
            Debtbl = CreateJournalTable();
            Cretbl = CreateJournalTable();
            LoadJournal();
        }
        protected void attempt_post_Click(object sender, EventArgs e)
        {

        }

        protected void AddDebBut0_Click(object sender, EventArgs e)
        {
            if (Int32.Parse(debit0.Text) != 0)
            {
                if (DebFileUpload0.HasFile)
                {
                    InsertJournalDetails(Debtbl, accDebt_title0.SelectedValue, DebFileUpload0.FileName, Debref0.Text, debit0.Text, "");
                    accDebt_title0.SelectedValue = "--Select--";
                    Debref0.Text = "";
                    debit0.Text = "";
                }
                else
                {
                    InsertJournalDetails(Debtbl, accDebt_title0.SelectedValue, "", Debref0.Text, debit0.Text, "");
                    accDebt_title0.SelectedValue = "--Select--";
                    Debref0.Text = "";
                    debit0.Text = "";
                }
            }

        }

        protected void AddCreBut0_Click(object sender, EventArgs e)
        {

        }

        protected void clear_entry_Click(object sender, EventArgs e)
        {
            Response.Redirect(Request.RawUrl);
        }

        private static DataTable CreateJournalTable()
        {
            DataTable JournalTable = new DataTable("JournalEntry");

            DataColumn colAccount = new DataColumn("AccountTitle", typeof(string));
            JournalTable.Columns.Add(colAccount);

            DataColumn colSrc = new DataColumn("Source", typeof(string));
            JournalTable.Columns.Add(colSrc);

            DataColumn colRef = new DataColumn("Ref", typeof(string));
            JournalTable.Columns.Add(colRef);

            DataColumn colDebit = new DataColumn("Debit", typeof(decimal));
            JournalTable.Columns.Add(colDebit);

            DataColumn colCredit = new DataColumn("Credit", typeof(decimal));
            JournalTable.Columns.Add(colCredit);
            
            return JournalTable;
        }

        private static void InsertJournalDetails(DataTable JournalTable, string Acc, string Src, string Ref, string Deb, string Cre)
        {            
            Object[] rows = new Object[]{Acc,Src,Ref,Deb,Cre};
                JournalTable.Rows.Add(rows);
        }

        private void LoadJournal()
        {
            DebGrid.DataSource = Debtbl;
            CreGrid.DataSource = Cretbl;
            DebGrid.DataBind();
            CreGrid.DataBind();
        }

    }
}