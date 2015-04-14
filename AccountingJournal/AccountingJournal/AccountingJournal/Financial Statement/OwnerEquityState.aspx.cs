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
            StringBuilder sb = new StringBuilder();
            List<OEStatement> OE = Connection.DisplayOEStatement().Cast<OEStatement>().ToList();
            foreach (OEStatement e in OE)
            {
                StrDat.Text = e.StartPeriod.ToString("MMMM dd, yyyy");
                StrAmt.Text = e.StartAmount.ToString("#,##0.00");
                if (e.Net >= 0)
                {
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td style='width:100px'>Add:</td>"));
                    sb.Append(string.Format(@"<td>Investments</td>"));               
                    sb.Append(string.Format(@"<td class='text-right'>$ {0}</td>",e.Investment.ToString("#,##0.00")));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"</tr>"));
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td>Net Income</td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin; width:100px;'>"));
                    sb.Append(string.Format(@"{0}</td>",(e.Net).ToString("#,##0.00")));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin; width:100px;'>"));
                    sb.Append(string.Format(@"{0}",(e.Investment + e.Net).ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right'>"));
                    sb.Append(string.Format(@"{0}",(e.Investment + e.Net + e.StartAmount).ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td>Less:</td>"));
                    sb.Append(string.Format(@"<td>Drawing</td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin'>"));
                    sb.Append(string.Format(@"{0}",e.Drawing.ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                }
                else
                {
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td style='width:100px'>Add:</td>"));
                    sb.Append(string.Format(@"<td>Investments</td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin; width:100px;'>$ {0}</td>", e.Investment.ToString("#,##0.00")));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin'>"));
                    sb.Append(string.Format(@"{0}", (e.Investment).ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                    
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right'>"));
                    sb.Append(string.Format(@"{0}", (e.Investment + e.StartAmount).ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td>Less:</td>"));
                    sb.Append(string.Format(@"<td>Drawing</td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right'>"));
                    sb.Append(string.Format(@"{0}", e.Drawing.ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));

                    sb.Append(string.Format(@"<tr>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td>Net Loss</td>"));
                    sb.Append(string.Format(@"<td>"));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"<td></td>"));
                    sb.Append(string.Format(@"<td class='text-right' style='border-bottom:solid thin; width:100px;'>"));
                    sb.Append(string.Format(@"{0}", (e.Net).ToString("#,##0.00")));
                    sb.Append(string.Format(@"</td>"));
                    sb.Append(string.Format(@"</tr>"));
                }
                OEDetail.Text = sb.ToString();
                Endtot.Text = (e.Investment + e.Net + e.StartAmount - e.Drawing).ToString("#,##0.00");
                Enddate = e.EndPeriod;
                EndDat.Text = e.EndPeriod.ToString("MMMM dd, yyyy");
                if ((e.Investment + e.Net + e.StartAmount - e.Drawing) < 0)
                {
                    Endtot.Attributes["Style"] = "color: red;";
                }
            }
        }
    }
}