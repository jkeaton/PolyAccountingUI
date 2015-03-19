<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="UnpostTransaction.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.UnpostTransaction" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                Unpost Transaction
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table borderless" id="Jourtab">
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-center">Date</td>
                        <td>Account Titles and Explanation</td>
                        <td>Ref.</td>
                        <td class="text-right">Debit</td>
                        <td class="text-right">Credit</td>
                        <td class="text-center">Action</td>
                    </tr>
                    <asp:Label ID="UnpostJour" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>

</asp:Content>
