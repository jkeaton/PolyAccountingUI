using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class TrialBl
    {
        public string Name { get; set; }
        public string IsDebit { get; set; }
        public decimal Total { get; set; }
        public int Rank { get; set; }
        public int AccNum { get; set; }
    }
}