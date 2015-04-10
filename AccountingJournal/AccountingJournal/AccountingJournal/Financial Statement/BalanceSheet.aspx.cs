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
    public partial class BalanceSheet : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DisplayBalanceSheet();
            CurDate.Text = DateTime.Now.ToString("MMMM dd, yyyy");
        }

        private void DisplayBalanceSheet()
        {
            float totalAsset = 0;
            float totalLia = 0;
            List<BalSheet> bs = Connection.DisplayBalanceSheet().Cast<BalSheet>().ToList();
            StringBuilder AssetSb = new StringBuilder();
            StringBuilder LiaSb = new StringBuilder();
            foreach (BalSheet b in bs)
            {
                if (b.type == "Asset")
                {
                    if(b.Rank == 1){
                        AssetSb.Append(string.Format(@"<tr>"));
                        AssetSb.Append(string.Format(@"<td>{0}</td>", b.Name));
                        AssetSb.Append(string.Format(@"<td style='text-align:right'>$ {0}</td>", b.Total.ToString("#,##0.00")));
                        AssetSb.Append(string.Format(@"</tr>"));
                    }
                    else
                    {
                        AssetSb.Append(string.Format(@"<tr>"));
                        AssetSb.Append(string.Format(@"<td>{0}</td>", b.Name));
                        AssetSb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", b.Total.ToString("#,##0.00")));
                        AssetSb.Append(string.Format(@"</tr>"));
                    }
                    totalAsset+=(float)b.Total;
                }

                else if (b.type == "Liability")
                {
                    if(b.Rank == 1){
                        LiaSb.Append(string.Format(@"<tr>"));
                        LiaSb.Append(string.Format(@"<td>Liabilities</td>"));
                        LiaSb.Append(string.Format(@"<td></td>"));
                        LiaSb.Append(string.Format(@"</tr>"));

                        LiaSb.Append(string.Format(@"<tr>"));
                        LiaSb.Append(string.Format(@"<td><div style='margin-left:20px'>{0}</div></td>", b.Name));
                        LiaSb.Append(string.Format(@"<td style='text-align:right'>$ {0}</td>", b.Total.ToString("#,##0.00")));
                        LiaSb.Append(string.Format(@"</tr>"));
                    }
                    else
                    {
                        LiaSb.Append(string.Format(@"<tr>"));
                        LiaSb.Append(string.Format(@"<td><div style='margin-left:20px'>{0}</div></td>", b.Name));
                        LiaSb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", b.Total.ToString("#,##0.00")));
                        LiaSb.Append(string.Format(@"</tr>"));
                    }
                    totalLia += (float)b.Total;
                }
                else
                {

                        LiaSb.Append(string.Format(@"<tr>"));
                        LiaSb.Append(string.Format(@"<td>Owner's Equity</td>"));
                        LiaSb.Append(string.Format(@"<td></td>"));
                        LiaSb.Append(string.Format(@"</tr>"));

                        LiaSb.Append(string.Format(@"<tr>"));
                        LiaSb.Append(string.Format(@"<td><div style='margin-left:20px'>{0}</div></td>", b.Name));
                        LiaSb.Append(string.Format(@"<td style='text-align:right'>{0}</td>", b.Total.ToString("#,##0.00")));
                        LiaSb.Append(string.Format(@"</tr>"));
                    
                    totalLia += (float)b.Total;
                }
            }
            AssetList.Text = AssetSb.ToString();
            LiaOWList.Text = LiaSb.ToString();
            TotalAssets.Text = "$ "+ totalAsset.ToString("#,##0.00");
            TotalLiaOE.Text = "$ " + totalLia.ToString("#,##0.00");
        }
    }
}