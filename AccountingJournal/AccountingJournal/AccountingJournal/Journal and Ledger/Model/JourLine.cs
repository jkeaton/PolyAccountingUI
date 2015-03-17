using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class JourLine
    {
        public int id { get; set; }
        public string Account { get; set; }
        public int AccNum { get; set; }
        public decimal? Debit { get; set; }
        public decimal? Credit { get; set; }
        public string IsDebit { get; set; }

        public JourLine(int id, string Acc, int Accnum, decimal? Debit, decimal? Credit, string isdebit)
        {
            this.id = id;
            Account = Acc;
            AccNum = Accnum;
            this.Debit = Debit;
            this.Credit = Credit;
            IsDebit = isdebit;
        }

        public override bool Equals(object obj)
        {
            if (obj == null) return false;
            JourLine objAsPart = obj as JourLine;
            if (objAsPart == null) return false;
            else return Equals(objAsPart);
        }

        public override int GetHashCode()
        {
            return id;
        }
        public bool Equals(JourLine other)
        {
            if (other == null) return false;
            return (this.id.Equals(other.id)&&this.Account.Equals(other.Account));
        }
    }
}