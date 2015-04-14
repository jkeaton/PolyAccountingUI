using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class JourHeader : IEquatable<JourHeader>
    {
        public int id { get; set; }
        public DateTime Date { get; set; }
        public DateTime? PostDate { get; set; }
        public int TotalAccEff { get; set; }

        public JourHeader(int id, DateTime CrDate, DateTime? posDate, int total)
        {
            this.id = id;
            Date = CrDate;
            PostDate = posDate;
            TotalAccEff = total;
        }

        public override bool Equals(object obj)
        {
            if (obj == null) return false;
            JourHeader objAsPart = obj as JourHeader;
            if (objAsPart == null) return false;
            else return Equals(objAsPart);
        }

        public override int GetHashCode()
        {
            return id;
        }
        public bool Equals(JourHeader other)
        {
            if (other == null) return false;
            return (this.id.Equals(other.id));
        }
    }
}