using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class IndiJournal
    {
        public DateTime date { get; set; }
        public string Account { get; set; }
        public string Desc { get; set; }
        public int AccNum { get; set; }
        public decimal? Debit { get; set; }
        public decimal? Credit { get; set; }
        public string IsDebit { get; set; }
        public DateTime? postdate { get; set; }
        public int TranxID { get; set; }
        public int TotalAccEff { get; set; }
    }
}