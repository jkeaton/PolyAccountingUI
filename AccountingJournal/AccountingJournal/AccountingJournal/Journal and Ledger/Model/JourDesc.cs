using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Journal_and_Ledger.Model
{
    public class JourDesc
    {
        public int id { get; set; }
        public string Desc { get; set; }

        public JourDesc(int id, string desc)
        {
            this.id = id;
            this.Desc = desc;
        }


        public override bool Equals(object obj)
        {
            if (obj == null) return false;
            JourDesc objAsPart = obj as JourDesc;
            if (objAsPart == null) return false;
            else return Equals(objAsPart);
        }

        public override int GetHashCode()
        {
            return id;
        }
        public bool Equals(JourDesc other)
        {
            if (other == null) return false;
            return (this.id.Equals(other.id));
        }
    }
}