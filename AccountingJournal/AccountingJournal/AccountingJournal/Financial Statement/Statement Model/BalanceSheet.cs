using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class BalSheet
    {
        public string type { get; set; }
        public string Name { get; set; }
        public decimal Total { get; set; }
        public int Rank { get; set; }
    }
}