using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Financial_Statement
{
    public partial class CashFlowStatement : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            CurDate.Text = LastDayofMonth(DateTime.Now).ToString("MMMM dd, yyyy");
        }

        public DateTime LastDayofMonth(DateTime dt)
        {

            dt = new DateTime(dt.Year, dt.Month, 1);
            dt = dt.AddMonths(1);

            dt = dt.AddDays(-1);
            return dt;

        }
    }
}