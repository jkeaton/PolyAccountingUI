<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="TrialBalance.aspx.cs" Inherits="AccountingJournal.Financial_Statement.TrialBalance" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div style="text-align: center; background-color: darkblue; color: white; height: 30px; font-size: large; vertical-align: central; font-weight: bold">
        Trial Balance
    </div>
    <div style="border: thick; border-color: darkblue;">
        <table style="width: 800px; margin-left: auto; margin-right: auto;">
            <tr>
                <td style="width: 400px; margin-left: 100px;"></td>
                <td style="width: 150px; text-align: right; font-weight:bolder; text-decoration:underline">Debit</td>
                <td style="width: 150px; text-align: right; font-weight:bolder; text-decoration:underline">Credit</td>
            </tr>
            <asp:Label ID="T_Balance" runat="server" Text="Label"></asp:Label>
            <tr>
                <td></td>
                <td>
                    <div style="text-align: Right">
                    <asp:Label ID="TotalDeb" runat="server" Style="border-bottom:double; border-top:solid thin" ></asp:Label>
                    </div>

                </td>
                <td>
                    <div style="text-align:right">
                    <asp:Label ID="TotalCre" runat="server" Style="border-bottom: double; border-top:solid thin; "></asp:Label>
                    </div>

                </td>
            </tr>
        </table>
    </div>
</asp:Content>
