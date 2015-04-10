using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class OEStatement
    {
        public DateTime StartPeriod { get; set; }
        public DateTime EndPeriod { get; set; }
        public decimal StartAmount { get; set; }
        public decimal Investment { get; set; }
        public decimal Drawing { get; set; }
        public decimal Net { get; set; }
    }
}