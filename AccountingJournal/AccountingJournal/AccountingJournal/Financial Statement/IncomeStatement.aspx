<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="IncomeStatement.aspx.cs" Inherits="AccountingJournal.Financial_Statement.IncomeStatement" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div style="text-align: center; background-color: darkblue; color: white; height: 30px; font-size: large; vertical-align: central; font-weight: bold">
        Income Statement
    </div>
    <div>
        <table style="width:700px; margin-left:auto; margin-right:auto">
            <asp:Label ID="IncState" runat="server" Text="Label"></asp:Label>
            <tr>
                <td></td>
                <td>
                    <div style="margin-left:20px"> Total Expenses</div></td>
                <td></td>
                <td style="text-align:right">
                    <asp:Label ID="tol_expense" runat="server" Style="border-bottom:solid thin"></asp:Label>
                </td>
            </tr>
                        <tr>
                
                <td colspan="2">Net Income</td>
                <td></td>
                <td>
                    <div style="text-align:right; color:red">
                    <asp:Label ID="Net_Inc" runat="server" Style="border-bottom:double"></asp:Label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</asp:Content>
