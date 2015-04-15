﻿<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="CashFlowStatement.aspx.cs" Inherits="AccountingJournal.Financial_Statement.CashFlowStatement" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Poly Accounting Information</h3>
                <h3 class="panel-title">Statement of Cash Flow
                    <br />
                    <asp:Label ID="CurDate" runat="server"></asp:Label>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table" style="width: 800px; margin-left: auto; margin-right: auto">
                    <asp:Label ID="cashflow" runat="server"></asp:Label>
                    <tr>
                        <td colspan="2">Net increase in cash</td>
                        <td></td>
                        <td>
                            <asp:Label ID="netcash" runat="server"></asp:Label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
