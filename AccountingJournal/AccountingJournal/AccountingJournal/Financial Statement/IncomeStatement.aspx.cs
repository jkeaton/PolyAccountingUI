using AccountingJournal.Code;
using AccountingJournal.Financial_Statement.Statement_Model;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace AccountingJournal.Financial_Statement
{
    public partial class IncomeStatement : System.Web.UI.Page
    {
        float tot_exp = 0;
        float tot_rev = 0;
        protected void Page_Load(object sender, EventArgs e)
        {
            LoadIncomeStatement();

            CurPeriod.Text = "For the Month Ended " + LastDayofMonth(DateTime.Now).ToString("MMMM dd, yyyy");
        }

        private void LoadIncomeStatement()
        {
            List<IncDetail> incsta = Connection.DisplayIncomeStatement().Cast<IncDetail>().ToList();
            List<string> AccType = new List<string>();
            StringBuilder sb = new StringBuilder();
            foreach (IncDetail ins in incsta)
            {
                if (!AccType.Contains(ins.AccountType))
                {
                    AccType.Add(ins.AccountType);
                }
            }

            Boolean firstDr = false;
            Boolean firstCr = false;
            for (int i = 0; i < AccType.Count; i++)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan='2'>{0}</td>", AccType[i]));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"</tr>"));
                for (int j = 0; j < incsta.Count; j++)
                {
                    if (incsta[j].total > 0)
                    {
                        if (incsta[j].AccountType == AccType[i] && (!firstDr || !firstCr))
                        {
                            if (incsta[j].IsDebit == "Debit" && !firstDr)
                            {
                                //sb.Append(string.Format(@"<td style='width:250; text-align:right;border-bottom:solid thin;'>{0}</td>", incsta[j].total.ToString("#,##0.00")));
                                sb.Append(string.Format(@"<tr>"));
                                sb.Append(string.Format(@"<td style='width:30px'></td>"));
                                sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                                sb.Append(string.Format(@"<td style='width:250; text-align:right'>$ {0}</td>", incsta[j].total.ToString("#,##0.00")));
                                sb.Append(string.Format(@"<td></td>"));
                                sb.Append(string.Format(@"</tr>"));
                                tot_exp += (float)incsta[j].total;
                                firstDr = true;
                            }
                            else if (!firstCr)
                            {
                                sb.Append(string.Format(@"<tr>"));
                                sb.Append(string.Format(@"<td style='width:30px'></td>"));
                                sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                                sb.Append(string.Format(@"<td></td>"));
                                sb.Append(string.Format(@"<td style='width:250; text-align:right'>$ {0}</td>", incsta[j].total.ToString("#,##0.00")));
                                sb.Append(string.Format(@"</tr>"));
                                tot_rev += (float)incsta[j].total;
                                firstCr = true;
                            }
                        }
                        else if (incsta[j].AccountType == AccType[i])
                        {
                            if (incsta[j].IsDebit == "Debit" && firstDr)
                            {
                                sb.Append(string.Format(@"<tr>"));
                                sb.Append(string.Format(@"<td style='width:30px'></td>"));
                                sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                                if (j == incsta.Count - 1)
                                {
                                    sb.Append(string.Format(@"<td style='width:250; text-align:right;'><span style='border-bottom: solid thin'>{0}</span></td>", incsta[j].total.ToString("#,##0.00")));
                                }
                                else
                                {
                                    sb.Append(string.Format(@"<td style='width:250; text-align:right'>{0}</td>", incsta[j].total.ToString("#,##0.00")));

                                }
                                sb.Append(string.Format(@"<td></td>"));
                                sb.Append(string.Format(@"</tr>"));
                                tot_exp += (float)incsta[j].total;
                            }
                            else if (firstCr)
                            {
                                sb.Append(string.Format(@"<tr>"));
                                sb.Append(string.Format(@"<td style='width:30px'></td>"));
                                sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                                sb.Append(string.Format(@"<td></td>"));
                                sb.Append(string.Format(@"<td style='width:250; text-align:right'>{0}</td>", incsta[j].total.ToString("#,##0.00")));
                                sb.Append(string.Format(@"</tr>"));
                                tot_rev += (float)incsta[j].total;
                            }
                        }
                    }
                }
            }
            tol_expense.Text = tot_exp.ToString("#,##0.00");
            Net_Inc.Text = "$ " + (tot_rev - tot_exp).ToString("#,##0.00");
            IncState.Text = sb.ToString();
            if ((tot_rev - tot_exp) < 0)
            {
                Net_Inc.Attributes["style"] = "color:red; border-bottom:double;";
            }
            else
            {
                Net_Inc.Attributes["style"] = "border-bottom:double;";
            }
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