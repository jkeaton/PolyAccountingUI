<<<<<<< HEAD
﻿using AccountingJournal.Code;
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
    public partial class CashFlowStatement : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            CurDate.Text = LastDayofMonth(DateTime.Now).ToString("MMMM dd, yyyy");
            CashFlowStatementDisplay();
        }

        private void CashFlowStatementDisplay()
        {
            float OperActivities = 0;
            float InvestActivities = 0;
            float finanAcitivities = 0;
            StringBuilder sb = new StringBuilder();
            List<CashFlow> cf = Connection.DisplayCashFlow().Cast<CashFlow>().ToList();
            List<CashFlow> operating = new List<CashFlow>();
            List<CashFlow> investing = new List<CashFlow>();
            List<CashFlow> financing = new List<CashFlow>();
            foreach (CashFlow c in cf)
            {
                if (c.AccType == "Capital" || c.AccType == "Drawings")
                {
                    financing.Add(c);
                }
                else if (c.AccType == "Revenue" || c.AccType == "Expense")
                {
                    operating.Add(c);
                }
                else if (c.AccType == "Current Asset/Long-Term Investment")
                {
                    investing.Add(c);
                }
            }
            if (operating.Count > 0)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan=2>Cash flows from operating activities</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));

                for (int i = 0; i < operating.Count; i++)
                {

                    if (operating[i].AccType == "Revenue")
                    {
                        OperActivities += (float)operating[i].Amount;
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(string.Format(@"<td stype='width:30px'></td>"));
                        sb.Append(string.Format(@"<td>Cash receipts from revenues</td>"));
                        sb.Append(string.Format(@"<td></td>"));
                        sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", operating[i].Amount.ToString("#,##0.00")));
                        sb.Append(string.Format(@"</tr>"));
                    }
                    else
                    {
                        OperActivities -= (float)operating[i].Amount;
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(string.Format(@"<td style='width:30px'></td>"));
                        sb.Append(string.Format(@"<td>Cash receipts from expenses</td>"));
                        sb.Append(string.Format(@"<td></td>"));
                        sb.Append(string.Format(@"<td style='text-align:right'>({0})</td>", operating[i].Amount.ToString("#,##0.00")));
                        sb.Append(string.Format(@"</tr>"));
                    }
                }

                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan=2>Net cash provided by operating activities</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", OperActivities.ToString("#,##0.00")));
                sb.Append(string.Format(@"</tr>"));

            }

            if (investing.Count > 0)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan=2>Cash flows from investing activities</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
                for (int i = 0; i < investing.Count; i++)
                {
                    InvestActivities += (float)investing[i].Amount;
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td style='width:30px'></td>"));
                    sb.Append(string.Format(@"<td>Investing activities</td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td style='text-align:right'>({0})</td>", investing[i].Amount.ToString("#,##0.00")));
                    sb.Append(string.Format(@"</tr>"));
                }
            }

            if (financing.Count > 0)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan=2>Cash flows from financing activities</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));

                for (int i = 0; i < financing.Count; i++)
                {

                    if (financing[i].AccType == "Capital")
                    {
                        finanAcitivities += (float)financing[i].Amount;
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(string.Format(@"<td stype='width:30px'></td>"));
                        sb.Append(string.Format(@"<td>Investments by owner</td>"));
                        sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", financing[i].Amount.ToString("#,##0.00")));
                        sb.Append(string.Format(@"<td></td>"));
                        sb.Append(string.Format(@"</tr>"));
                    }
                    else
                    {
                        finanAcitivities -= (float)financing[i].Amount;
                        sb.Append(string.Format(@"<tr>"));
                        sb.Append(string.Format(@"<td style='width:30px'></td>"));
                        sb.Append(string.Format(@"<td>Drawings by owner</td>"));
                        sb.Append(string.Format(@"<td style='text-align:right'>({0})</td>", financing[i].Amount.ToString("#,##0.00")));
                        sb.Append(string.Format(@"<td></td>"));
                        sb.Append(string.Format(@"</tr>"));
                    }
                }

                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan=2>Net cash provided by operating activities</td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", finanAcitivities.ToString("#,##0.00")));
                sb.Append(string.Format(@"</tr>"));
            }

            cashflow.Text = sb.ToString();
        }

        public DateTime LastDayofMonth(DateTime dt)
        {

            dt = new DateTime(dt.Year, dt.Month, 1);
            dt = dt.AddMonths(1);

            dt = dt.AddDays(-1);
            return dt;

        }
    }
=======
﻿using System;
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
>>>>>>> b4fc1581393ed780d6d4bba029f85653d4e6c936
}