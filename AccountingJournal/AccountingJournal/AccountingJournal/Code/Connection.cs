using AccountingJournal.Financial_Statement.Statement_Model;
using AccountingJournal.Journal_and_Ledger.Model;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Web;

namespace AccountingJournal.Code
{
    public class Connection
    {
        private static SqlConnection conn;
        private static SqlCommand cmd;
        private static int count;
        static Connection()
        {
            string ConnectionString = ConfigurationManager.ConnectionStrings["TransactionDBConnectionString"].ToString();
            conn = new SqlConnection(ConnectionString);
            cmd = new SqlCommand("", conn);
        }

        public static int GetNumofUserByUsernameAndPassword(string usn, string pass)
        {
            string query = string.Format("SELECT count(*)"
                                        + " FROM         [User] INNER JOIN UserType ON [User].UType = UserType.TypeID "
                                        + " WHERE		[User].UserName = '{0}' "
                                        + " AND			[User].PWHash = '{1}'", usn, pass);
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    count = reader.GetInt32(0);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return count;
        }

        public static ArrayList GetUserByUsernameAndPassword(string usn, string pass)
        {
            ArrayList list = new ArrayList();
            User user = new User();
            string query = string.Format("SELECT [User].ID, [User].FName, [User].LName, [User].UserName, [User].PWHash, isnull([User].Email,''), UserType.Name "
                                        + " FROM         [User] INNER JOIN UserType ON [User].UType = UserType.TypeID "
                                        + " WHERE		[User].UserName = '{0}' "
                                        + " AND			[User].PWHash = '{1}'", usn, pass);
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    user.ID = reader.GetInt32(0);
                    user.FirstName = reader.GetString(1);
                    user.LastName = reader.GetString(2);
                    user.Username = reader.GetString(3);
                    user.Password = reader.GetString(4);
                    user.Email = reader.GetString(5);
                    user.UserType = reader.GetString(6);

                    list.Add(user);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayIncomeStatement()
        {
            ArrayList list = new ArrayList();
            IncDetail income;
            string query = string.Format("SELECT ct.Type as AccountType, c.Name as AccountName, c.Balance as Total, "
                                            + " ROW_NUMBER() OVER(PARTITION BY ct.type ORDER BY AccNumber) as [RANK], "
                                            + " CASE WHEN c.[IsDebit] = 0 then 'Credit' else 'Debit' END as IsDebit"
                                            + " FROM            Account c INNER JOIN"
                                            + "                 AccType ct ON c.AccTypeID = ct.TypeID"
                                            + " WHERE ct.Type IN('Expense','Revenue')"
                                            + " AND isActive =1 "
                                            + " AND c.Balance > 0"
                                            + " Order BY ct.TypeID, 4 asc");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    income = new IncDetail();
                    income.AccountType = reader.GetString(0);
                    income.Account = reader.GetString(1);
                    income.total = reader.GetDecimal(2);
                    income.Rank = Int32.Parse(reader.GetValue(3).ToString());
                    income.IsDebit = reader.GetString(4);
                    list.Add(income);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayTrialBalance()
        {
            ArrayList list = new ArrayList();
            TrialBl trb;
            string query = string.Format("SELECT [Name],CASE WHEN a.[IsDebit] = 0 then 'Credit' else 'Debit' END as IsDebit,a.Balance as total "
                                            + ", ROW_NUMBER() OVER(PARTITION BY a.isDebit order by AccNumber) as [Rank],AccNumber "
                                            + "FROM [TransactionDB].[dbo].[Account] a "
                                            + "WHERE Balance <> 0"
                                            + "order by AccNumber");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    trb = new TrialBl();
                    trb.Name = reader.GetString(0);
                    trb.IsDebit = reader.GetString(1);
                    trb.Total = reader.GetDecimal(2);
                    trb.Rank = Int32.Parse(reader.GetValue(3).ToString());
                    trb.AccNum = reader.GetInt32(4);
                    list.Add(trb);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayChartofAcc()
        {
            ArrayList list = new ArrayList();
            ChartofAcc CAcc;
            string query = string.Format("SELECT * FROM [TransactionDB].[dbo].[Chart_of_Accounts] order by 2");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    CAcc = new ChartofAcc();
                    CAcc.AccType = reader.GetString(0);
                    CAcc.ID = reader.GetInt32(1);
                    CAcc.AccNum = reader.GetInt32(2);
                    CAcc.Account = reader.GetString(3);
                    CAcc.AccDate = reader.GetDateTime(4);
                    CAcc.Balance = reader.GetDecimal(5);
                    CAcc.NorBal = reader.GetString(6);
                    CAcc.Group = reader.GetString(7);
                    list.Add(CAcc);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayGenLedger(string id)
        {
            ArrayList list = new ArrayList();
            Ledger G_Ledger;
            string query = string.Format("EXECUTE DisplayLedger {0}", id);
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    G_Ledger = new Ledger();
                    G_Ledger.AccNumber = reader.GetInt32(1);
                    G_Ledger.Account = reader.GetString(2);
                    G_Ledger.date = reader.GetDateTime(3);
                    G_Ledger.Description = reader.GetString(4);
                    G_Ledger.Ref = reader.GetString(5);
                    if (!reader.IsDBNull(6))
                    {
                        G_Ledger.Debit = reader.GetDecimal(6);
                    }
                    if (!reader.IsDBNull(7))
                    {
                        G_Ledger.Credit = reader.GetDecimal(7);
                    }
                    G_Ledger.Balance = reader.GetDecimal(8);
                    G_Ledger.TranxID = reader.GetInt32(9);
                    list.Add(G_Ledger);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayIndiJournal(string id)
        {
            ArrayList list = new ArrayList();
            IndiJournal Journal;
            string query = string.Format("EXECUTE [DisplayIndivJournal] {0}", id);
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    Journal = new IndiJournal();
                    Journal.date = reader.GetDateTime(0);
                    Journal.Account = reader.GetString(1);
                    Journal.Desc = reader.GetString(2);
                    Journal.AccNum = reader.GetInt32(3);
                    if (!reader.IsDBNull(4))
                    {
                        Journal.Debit = reader.GetDecimal(4);
                    }
                    if (!reader.IsDBNull(5))
                    {
                        Journal.Credit = reader.GetDecimal(5);
                    }
                    Journal.IsDebit = reader.GetString(6);
                    Journal.postdate = reader.GetDateTime(7);
                    Journal.TranxID = reader.GetInt32(8);
                    Journal.TotalAccEff = reader.GetInt32(9);
                    list.Add(Journal);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayJournal()
        {
            ArrayList list = new ArrayList();
            IndiJournal Journal;
            string query = string.Format("SELECT [Date]"
                                 + " ,[Name]"
                                 + " ,[Desc]"
                                 + " , AccNumber"
                                 + " , CASE WHEN IsDebit = 1 then Amount end as Debit"
                                 + " , CASE WHEN IsDebit = 0 then Amount end as Crebit"
                                 + " , CASE WHEN IsDebit = 1 then 'Debit' else 'Credit' end as IsDebit"
                                 + " , PostDate"
                                 + " , TranxID"
                                 + " , (select count(distinct j1.AccountID) from [TransactionDB].[dbo].[Journal] j1 where j1.TranxID = j.TranxID) as totAccEff"
                                 + "   FROM [TransactionDB].[dbo].[Journal] j"
                                 + "   WHERE PostDate IS NOT NULL"
                                 + "  order by 1 desc, 7 desc");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    Journal = new IndiJournal();
                    Journal.date = reader.GetDateTime(0);
                    Journal.Account = reader.GetString(1);
                    Journal.Desc = reader.GetString(2);
                    Journal.AccNum = reader.GetInt32(3);
                    if (!reader.IsDBNull(4))
                    {
                        Journal.Debit = reader.GetDecimal(4);
                    }
                    if (!reader.IsDBNull(5))
                    {
                        Journal.Credit = reader.GetDecimal(5);
                    }
                    Journal.IsDebit = reader.GetString(6);
                    if (!reader.IsDBNull(7))
                    {
                        Journal.postdate = reader.GetDateTime(7);
                    }
                    Journal.TranxID = reader.GetInt32(8);
                    Journal.TotalAccEff = reader.GetInt32(9);
                    list.Add(Journal);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayOEStatement()
        {
            ArrayList list = new ArrayList();
            OEStatement OwnEq;
            string query = string.Format("EXEC DisplayOEStatement");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    OwnEq = new OEStatement();
                    OwnEq.StartPeriod = reader.GetDateTime(0);
                    OwnEq.EndPeriod = reader.GetDateTime(1);
                    OwnEq.StartAmount = reader.GetDecimal(2);
                    OwnEq.Investment = reader.GetDecimal(3);
                    OwnEq.Drawing = reader.GetDecimal(4);
                    OwnEq.Net = reader.GetDecimal(5);
                    list.Add(OwnEq);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayBalanceSheet()
        {
            ArrayList list = new ArrayList();
            BalSheet bs = new BalSheet();
            string query = string.Format("EXEC DisplayBalancesheet");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    bs = new BalSheet();
                    bs.type = reader.GetString(0);
                    bs.Name = reader.GetString(1);
                    bs.Total = reader.GetDecimal(2);
                    bs.Rank = Int32.Parse(reader.GetValue(3).ToString());
                    list.Add(bs);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }


        public static ArrayList DisplayUnpostTranx()
        {
            ArrayList list = new ArrayList();
            IndiJournal Journal;
            string query = string.Format("SELECT [Date]"
                                 + " ,[Name]"
                                 + " ,[Desc]"
                                 + " , AccNumber"
                                 + " , CASE WHEN IsDebit = 1 then Amount end as Debit"
                                 + " , CASE WHEN IsDebit = 0 then Amount end as Crebit"
                                 + " , CASE WHEN IsDebit = 1 then 'Debit' else 'Credit' end as IsDebit"
                                 + " , PostDate"
                                 + " , TranxID"
                                 + " , (select count(distinct j1.AccountID) from [TransactionDB].[dbo].[Journal] j1 where j1.TranxID = j.TranxID) as totAccEff"
                                 + "   FROM [TransactionDB].[dbo].[Journal] j"
                                 + "   WHERE PostDate IS NULL"
                                 + "   AND NOT EXISTS"
                                 + "   ("
                                 + "   	SELECT 1 FROM [dbo].[Rejected] WHERE TranxID = j.TranxID"
                                 + "   ) order by 1 desc, 7 desc");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    Journal = new IndiJournal();
                    Journal.date = reader.GetDateTime(0);
                    Journal.Account = reader.GetString(1);
                    Journal.Desc = reader.GetString(2);
                    Journal.AccNum = reader.GetInt32(3);
                    if (!reader.IsDBNull(4))
                    {
                        Journal.Debit = reader.GetDecimal(4);
                    }
                    if (!reader.IsDBNull(5))
                    {
                        Journal.Credit = reader.GetDecimal(5);
                    }
                    Journal.IsDebit = reader.GetString(6);
                    if (!reader.IsDBNull(7))
                    {
                        Journal.postdate = reader.GetDateTime(7);
                    }
                    Journal.TranxID = reader.GetInt32(8);
                    Journal.TotalAccEff = reader.GetInt32(9);
                    list.Add(Journal);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static DataTable ManageAccDisplay()
        {
            string query = string.Format("EXEC [ManageAccount]");
            DataTable dt = new DataTable();
            try
            {
                conn.Open();
                SqlDataAdapter adpt = new SqlDataAdapter(query, conn);
                adpt.Fill(dt);
            }
            catch (Exception e)
            {
                Console.WriteLine(e);
            }
            finally
            {
                conn.Close();
            }
            return dt;
        }

        public static void UpdateActiveAcc(int ID, bool isactive)
        {
            string query = string.Format("[ActivateAccount] {0}, {1}", ID, isactive == true ? 1 : 0);
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
            }
            //catch (Exception e)
            //{
            //    Console.WriteLine(e);
            //}
            finally
            {
                conn.Close();
            }
        }

        public static ArrayList DisplayCashFlow()
        {
            ArrayList list = new ArrayList();
            CashFlow cf = new CashFlow();
            string query = string.Format("select type, IsDebit, sum(amount) as Amount"
                                            + " from DisplayCashFlowStatement"
                                            + " group by type, IsDebit");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    cf = new CashFlow();
                    cf.AccType = reader.GetString(0);
                    cf.IsDebit = reader.GetString(1);
                    cf.Amount = reader.GetDecimal(2);
                    list.Add(cf);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }

        public static ArrayList DisplayRejectedTranx()
        {
            ArrayList list = new ArrayList();
            RejectedTranx Rejected;
            string query = string.Format("SELECT * , (select count(distinct j1.AccountID) from [TransactionDB].[dbo].RejectedTranx j1 where j1.TranxID = j.TranxID) as totAccEff from RejectedTranx j order by TranxID, IsDebit desc");
            try
            {
                conn.Open();
                cmd.CommandText = query;
                SqlDataReader reader = cmd.ExecuteReader();
                while (reader.Read())
                {
                    Rejected = new RejectedTranx();
                    Rejected.date = reader.GetDateTime(0);
                    Rejected.Account = reader.GetString(1);
                    Rejected.Desc = reader.GetString(2);
                    Rejected.AccNum = reader.GetInt32(3);
                    if (!reader.IsDBNull(4))
                    {
                        Rejected.Debit = reader.GetDecimal(4);
                    }
                    if (!reader.IsDBNull(5))
                    {
                        Rejected.Credit = reader.GetDecimal(5);
                    }
                    Rejected.IsDebit = reader.GetString(6);
                    Rejected.TranxID = reader.GetInt32(7);
                    Rejected.RejectedUser = reader.GetString(8);
                    Rejected.TotalAccEff = reader.GetInt32(10);
                    list.Add(Rejected);
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
            finally
            {
                conn.Close();
            }
            return list;
        }
    }


}