﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AccountingJournal.Code
{
    public class User
    {
        public int ID { get; set; }
        public string Username { get; set; }
        public string Email { get; set; }
        public string UserType { get; set; }
        public string FirstName { get; set; }
        public string LastName { get; set; }
        public int isDisabled { get; set; }
    }
}