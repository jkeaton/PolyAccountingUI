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

            for (int i = 0; i < AccType.Count; i++)
            {
                sb.Append(string.Format(@"<tr>"));
                sb.Append(string.Format(@"<td colspan='2'>{0}</td>",AccType[i]));
                sb.Append(string.Format(@"<td></td>"));
                sb.Append(string.Format(@"<td><td>"));
                sb.Append(string.Format(@"</tr>"));
                for (int j = 0; j < incsta.Count; j++)
                {
                    if (incsta[j].AccountType == AccType[i] && incsta[j].Rank == 1)
                    {
                        if (incsta[j].IsDebit == "Debit")
                        {
                            sb.Append(string.Format(@"<tr>"));
                            sb.Append(string.Format(@"<td style='width:30px'></td>"));
                            sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                            sb.Append(string.Format(@"<td style='width:250; text-align:right'>$ {0}</td>", incsta[j].total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"<td></td>"));
                            sb.Append(string.Format(@"</tr>"));
                            tot_exp += (float)incsta[j].total;
                        }
                        else
                        {
                            sb.Append(string.Format(@"<tr>"));
                            sb.Append(string.Format(@"<td style='width:30px'></td>"));
                            sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                            sb.Append(string.Format(@"<td></td>"));
                            sb.Append(string.Format(@"<td style='width:250; text-align:right'>$ {0}</td>", incsta[j].total.ToString("#,##0.00")));
                            sb.Append(string.Format(@"</tr>"));
                            tot_rev += (float)incsta[j].total;
                        }
                    }
                    else if (incsta[j].AccountType == AccType[i] && incsta[j].Rank != 1)
                    {
                        if (incsta[j].IsDebit == "Debit")
                        {
                            sb.Append(string.Format(@"<tr>"));
                            sb.Append(string.Format(@"<td style='width:30px'></td>"));
                            sb.Append(string.Format(@"<td style='width:400px'>{0}</td>", incsta[j].Account));
                            if (j == incsta.Count - 1)
                            {
                                sb.Append(string.Format(@"<td style='width:250; text-align:right; border-bottom:solid thin'>{0}</td>", incsta[j].total.ToString("#,##0.00")));
                            }
                            else
                            {
                            sb.Append(string.Format(@"<td style='width:250; text-align:right'>{0}</td>", incsta[j].total.ToString("#,##0.00")));

                            }
                            sb.Append(string.Format(@"<td></td>"));
                            sb.Append(string.Format(@"</tr>"));
                            tot_exp += (float)incsta[j].total;
                        }
                        else
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
            tol_expense.Text = tot_exp.ToString("#,##0.00");
            Net_Inc.Text = "$ " + (tot_rev - tot_exp).ToString("#,##0.00");
            IncState.Text = sb.ToString();
        }
    }
}