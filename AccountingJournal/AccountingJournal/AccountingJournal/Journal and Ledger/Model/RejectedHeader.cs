using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class RejectedHeader : IEquatable<RejectedHeader>
    {
        public int id { get; set; }
        public DateTime Date { get; set; }
        public string RejectedUser { get; set; }
        public int TotalAccEff { get; set; }


        public RejectedHeader(int id, DateTime CrDate, string user, int t)
        {
            this.id = id;
            Date = CrDate;
            RejectedUser = user;
            TotalAccEff = t;
        }

        public override bool Equals(object obj)
        {
            if (obj == null) return false;
            RejectedHeader objAsPart = obj as RejectedHeader;
            if (objAsPart == null) return false;
            else return Equals(objAsPart);
        }

        public override int GetHashCode()
        {
            return id;
        }
        public bool Equals(RejectedHeader other)
        {
            if (other == null) return false;
            return (this.id.Equals(other.id));
        }
    }
}