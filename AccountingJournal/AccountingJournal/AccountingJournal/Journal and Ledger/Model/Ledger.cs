using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class Ledger
    {
        public DateTime date { get; set; }
        public string Description { get; set; }
        public string Ref { get; set; }
        public decimal? Debit { get; set; }
        public decimal? Credit { get; set; }
        public decimal Balance { get; set; }
        public string Account { get; set; }
        public int AccNumber { get; set; }
        public int TranxID { get; set; }
    }
}