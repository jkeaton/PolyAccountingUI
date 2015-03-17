using AccountingJournal.Code;
using AccountingJournal.Financial_Statement.Statement_Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Financial_Statement
{
    public partial class OwnerEquityState : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DisplayOEStatement();
        }
        public DateTime Enddate { get; set; }
        public void DisplayOEStatement()
        {
            List<OEStatement> OE = Connection.DisplayOEStatement().Cast<OEStatement>().ToList();
            foreach (OEStatement e in OE)
            {
                StrDat.Text = e.StartPeriod.ToString("MMMM dd, yyyy");
                StrAmt.Text = e.StartAmount.ToString("#,##0.00");
                InvAmt.Text = e.Investment.ToString("#,##0.00");
                if (e.Net < 0)
                {
                    NetLabel.Text = "Net Loss";
                    NetAmt.Text = (-e.Net).ToString("#,##0.00");
                }
                else
                {
                    NetLabel.Text = "Net Income";
                    NetAmt.Text = (e.Net).ToString("#,##0.00");
                }
                AddTot.Text = (e.Investment + e.Net).ToString("#,##0.00");
                subtotal.Text = (e.Investment + e.Net + e.StartAmount).ToString("#,##0.00");
                DrwAmt.Text = e.Drawing.ToString("#,##0.00");
                Endtot.Text = (e.Investment + e.Net + e.StartAmount - e.Drawing).ToString("#,##0.00");
                Enddate = e.EndPeriod;
                EndDat.Text = e.EndPeriod.ToString("MMMM dd, yyyy");
            }
        }
    }
}