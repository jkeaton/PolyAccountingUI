<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="IncomeStatement.aspx.cs" Inherits="AccountingJournal.Financial_Statement.IncomeStatement" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                <h3 class="panel-title">
                    Income Statement
                </h3>
            </div>
            <div class="panel-body">
                <table class="table" style="width:auto; margin-left:auto; margin-right:auto">
                    <asp:Label ID="IncState" runat="server" Text="Label"></asp:Label>
                    <tr>
                        <td></td>
                        <td>
                            <div style="margin-left: 20px">Total Expenses</div>
                        </td>
                        <td></td>
                        <td style="text-align: right;">
                            <span style="border-bottom: solid thin;">
                                <asp:Label ID="tol_expense" runat="server"></asp:Label>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Net Income</td>
                        <td></td>
                        <td>
                            <div style="text-align: right;">
                                <asp:Label ID="Net_Inc" runat="server" Style="border-bottom: double"></asp:Label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

   
</asp:Content>
