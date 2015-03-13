using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class IncDetail
    {
        public string AccountType { get; set; }
        public string Account { get; set; }
        public decimal total { get; set; }
        public int Rank { get; set; }
        public string IsDebit { get; set; }
    }
}