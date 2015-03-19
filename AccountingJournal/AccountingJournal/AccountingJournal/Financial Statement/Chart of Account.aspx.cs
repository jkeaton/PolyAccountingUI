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
    public partial class Chart_of_Account : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            LoadChartofAcc();
        }

        private void LoadChartofAcc()
        {
            StringBuilder asSb = new StringBuilder();
            StringBuilder liSb = new StringBuilder();
            StringBuilder OWSb = new StringBuilder();
            StringBuilder ReSb = new StringBuilder();
            StringBuilder ExpSb = new StringBuilder();
            List<ChartofAcc> ca = Connection.DisplayChartofAcc().Cast<ChartofAcc>().ToList();
            for (int i = 0; i < ca.Count; i++)
            {
                if (ca[i].AccType == "Asset")
                {
                    asSb.Append(string.Format(@"<tr class='info'>"));
                    asSb.Append(string.Format(@"<td class='text-left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-align:left; text-decoration:none; color:black;'>{0}</a></td>", ca[i].Account, ca[i].AccNum));
                    asSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccNum));
                    asSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccDate.ToShortDateString()));
                    asSb.Append(string.Format(@"<td>{0}</td>", ca[i].Group));
                    asSb.Append(string.Format(@"<td class='text-right'>{0}</td>", ca[i].Balance.ToString("#,##0.00")));
                    asSb.Append(string.Format(@"<td>{0}</td>", ca[i].NorBal));
                    asSb.Append(string.Format(@"</tr>"));
                }
                else if (ca[i].AccType == "Liability")
                {
                    liSb.Append(string.Format(@"<tr class='info'>"));
                    liSb.Append(string.Format(@"<td class='text-left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-align:left; text-decoration:none; color:black;'>{0}</a></td>", ca[i].Account, ca[i].ID));
                    liSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccNum));
                    liSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccDate.ToShortDateString()));
                    liSb.Append(string.Format(@"<td>{0}</td>", ca[i].Group));
                    liSb.Append(string.Format(@"<td class='text-right'>{0}</td>", ca[i].Balance.ToString("#,##0.00")));
                    liSb.Append(string.Format(@"<td>{0}</td>", ca[i].NorBal));
                    liSb.Append(string.Format(@"</tr>"));
                }
                else if (ca[i].AccType == "Owner's Equity")
                {
                    OWSb.Append(string.Format(@"<tr>"));
                    OWSb.Append(string.Format(@"<td class='text-left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; color:black;'>{0}</a></td>", ca[i].Account, ca[i].ID));
                    OWSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccNum));
                    OWSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccDate.ToShortDateString()));
                    OWSb.Append(string.Format(@"<td>{0}</td>", ca[i].Group));
                    OWSb.Append(string.Format(@"<td class='text-right'>{0}</td>", ca[i].Balance.ToString("#,##0.00")));
                    OWSb.Append(string.Format(@"<td>{0}</td>", ca[i].NorBal));
                    OWSb.Append(string.Format(@"</tr>"));
                }
                else if (ca[i].AccType == "Revenue")
                {
                    ReSb.Append(string.Format(@"<tr>"));
                    ReSb.Append(string.Format(@"<td class='text-left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; color:black;'>{0}</a></td>", ca[i].Account, ca[i].ID));
                    ReSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccNum));
                    ReSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccDate.ToShortDateString()));
                    ReSb.Append(string.Format(@"<td>{0}</td>", ca[i].Group));
                    ReSb.Append(string.Format(@"<td class='text-right'>{0}</td>", ca[i].Balance.ToString("#,##0.00")));
                    ReSb.Append(string.Format(@"<td>{0}</td>", ca[i].NorBal));
                    ReSb.Append(string.Format(@"</tr>"));
                }
                else if (ca[i].AccType == "Expense")
                {
                    ExpSb.Append(string.Format(@"<tr>"));
                    ExpSb.Append(string.Format(@"<td class='text-left'><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-decoration:none; color:black;'>{0}</a></td>", ca[i].Account, ca[i].ID));
                    ExpSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccNum));
                    ExpSb.Append(string.Format(@"<td>{0}</td>", ca[i].AccDate.ToShortDateString()));
                    ExpSb.Append(string.Format(@"<td>{0}</td>", ca[i].Group));
                    ExpSb.Append(string.Format(@"<td class='text-right'>{0}</td>", ca[i].Balance.ToString("#,##0.00")));
                    ExpSb.Append(string.Format(@"<td>{0}</td>", ca[i].NorBal));
                    ExpSb.Append(string.Format(@"</tr>"));
                }
            }
            ChrAsset.Text = asSb.ToString();
            ChrLiab.Text = liSb.ToString();
            ChrOw.Text = OWSb.ToString();
            ChrRev.Text = ReSb.ToString();
            ChrExp.Text = ExpSb.ToString();
        }



        //private void LoadChartofAcc()
        //{
        //    StringBuilder AssSb = new StringBuilder();
        //    StringBuilder LiaSb = new StringBuilder();
        //    StringBuilder OEquiSb = new StringBuilder();
        //    StringBuilder RevSb = new StringBuilder();
        //    StringBuilder ExpSb = new StringBuilder();
        //    List<ChartofAcc> ca = Connection.DisplayChartofAcc().Cast<ChartofAcc>().ToList();
        //    List<string> Acctype = new List<string>();
        //    foreach (ChartofAcc c in ca)
        //    {
        //        if (!Acctype.Contains(c.AccType))
        //        {
        //            Acctype.Add(c.AccType);
        //        }
        //    }
        //    for (int i = 0; i < Acctype.Count; i++)
        //    {
        //        switch (Acctype[i])
        //        {
        //            case "Asset":
        //                ChartDrawing(AssSb, ca, Acctype, i);
        //                break;
        //            case "Liability":
        //                ChartDrawing(LiaSb, ca, Acctype, i);
        //                break;
        //            case "Owner's Equity":
        //                ChartDrawing(OEquiSb, ca, Acctype, i);
        //                break;
        //            case "Expense":
        //                ChartDrawing(ExpSb, ca, Acctype, i);
        //                break;
        //            case "Revenue":
        //                ChartDrawing(RevSb, ca, Acctype, i);
        //                break;
        //        }
        //    }
        //    Asset.Text = AssSb.ToString();
        //    Lia.Text = LiaSb.ToString();
        //    OEqu.Text = OEquiSb.ToString();
        //    Expe.Text = ExpSb.ToString();
        //    Reve.Text = RevSb.ToString();
        //}

        //private static void ChartDrawing(StringBuilder sb, List<ChartofAcc> ca, List<string> Acctype, int i)
        //{
        //    sb.Append(string.Format(@"<tr>"));
        //    sb.Append(string.Format(@"<td colspan='2' style='font-weight:bold; text-align:center; border-bottom:solid thin; background-color:lightyellow'>{0}</td>", Acctype[i]));
        //    sb.Append(string.Format(@"</tr>"));
        //    for (int j = 0; j < ca.Count; j++)
        //    {
        //        if (ca[j].AccType == Acctype[i])
        //        {
        //            sb.Append(string.Format(@"<tr>"));
        //            sb.Append(string.Format(@"<td style='width:70px'>{0}</td>", ca[j].ID));
        //            sb.Append(string.Format(@"<td><a href='../Journal and Ledger/General Ledger.aspx?ID={1}' style='text-align:left; text-decoration:none; color:black;'>{0}</a></td>", ca[j].Account, ca[j].ID));
        //            sb.Append(string.Format(@"</tr>"));
        //        }
        //    }
        //}
    }
}