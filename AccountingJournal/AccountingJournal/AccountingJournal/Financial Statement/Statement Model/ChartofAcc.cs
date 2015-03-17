using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Financial_Statement.Statement_Model
{
    public class ChartofAcc
    {
        public string AccType { get; set; }
        public int ID { get; set; }
        public string Account { get; set; }
        public int AccNum { get; set; }
        public DateTime AccDate { get; set; }
        public string Group { get; set; }
        public decimal Balance { get; set; }
        public string NorBal { get; set; }
    }
}