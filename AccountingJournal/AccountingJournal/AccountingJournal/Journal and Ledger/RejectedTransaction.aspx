﻿<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="RejectedTransaction.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.RejectedTransaction" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                Rejected Transaction
            </div>
            <div class="panel-body" style="background-color: #e3edf5; height: 500px; overflow: auto;">
                <table class="table borderless" id="Jourtab">
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-center">Date</td>
                        <td>Account Titles and Explanation</td>
                        <td class="text-right">Ref.</td>
                        <td class="text-right">Debit</td>
                        <td class="text-right">Credit</td>
                        <td class="text-center">Rejected User</td>
                    </tr>
                    <asp:Label ID="RejTranx" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>