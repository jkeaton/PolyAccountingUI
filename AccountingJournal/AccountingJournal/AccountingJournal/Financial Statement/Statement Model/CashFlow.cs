using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class CashFlow
    {
        public string AccName { get; set; }
        public string AccType { get; set; }
        public string IsDebit { get; set; }
        public decimal Amount { get; set; }
    }
}