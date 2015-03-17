<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="Chart of Account.aspx.cs" Inherits="AccountingJournal.Financial_Statement.Chart_of_Account" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading ">
                Chart of Account
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="6">Assets</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left">Account Name</td>
                        <td>Account Number</td>
                        <td>Create Date</td>
                        <td>Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrAsset" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover">
                    <tr class="active">
                        <td colspan="6">Liability</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left">Account Name</td>
                        <td>Account Number</td>
                        <td>Create Date</td>
                        <td>Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrLiab" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover">
                    <tr class="active">
                        <td colspan="6">Owner's Equity</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left">Account Name</td>
                        <td>Account Number</td>
                        <td>Create Date</td>
                        <td>Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrOw" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover">
                    <tr class="active">
                        <td colspan="6">Revenue</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left">Account Name</td>
                        <td>Account Number</td>
                        <td>Create Date</td>
                        <td>Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrRev" runat="server"></asp:Label>
                </table>
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover">
                    <tr class="active">
                        <td colspan="6">Expenses</td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-left">Account Name</td>
                        <td>Account Number</td>
                        <td>Create Date</td>
                        <td>Group</td>
                        <td class="text-right">Balance</td>
                        <td>Normal Balance</td>
                    </tr>
                    <asp:Label ID="ChrExp" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
