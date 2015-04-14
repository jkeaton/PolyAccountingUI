<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="Chart of Account.aspx.cs" Inherits="AccountingJournal.Financial_Statement.Chart_of_Account" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading">
                <h3>Poly Accounting Information</h3>
                <h3 class="panel-title">Chart of Accounts
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="active" style="font-weight: bolder">
                        <td colspan="6">Assets</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left" style="width: 350px;">Account Name</td>
                        <td style="width: 130px">Account Number</td>
                        <td>Create Date</td>
                        <td style="width: 200px">Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrAsset" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="active" style="font-weight: bolder">
                        <td colspan="6">Liabilities</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left" style="width: 350px;">Account Name</td>
                        <td style="width: 130px">Account Number</td>
                        <td>Create Date</td>
                        <td style="width: 200px">Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrLiab" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="active" style="font-weight: bolder">
                        <td colspan="6">Owner's Equity</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left" style="width: 350px;">Account Name</td>
                        <td style="width: 130px">Account Number</td>
                        <td>Create Date</td>
                        <td style="width: 200px">Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrOw" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="active" style="font-weight: bolder">
                        <td colspan="6">Revenue</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left" style="width: 350px;">Account Name</td>
                        <td style="width: 130px">Account Number</td>
                        <td>Create Date</td>
                        <td style="width: 200px">Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrRev" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="active" style="font-weight: bolder">
                        <td colspan="6">Expenses</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left" style="width: 350px;">Account Name</td>
                        <td style="width: 130px">Account Number</td>
                        <td>Create Date</td>
                        <td style="width: 200px">Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrExp" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
