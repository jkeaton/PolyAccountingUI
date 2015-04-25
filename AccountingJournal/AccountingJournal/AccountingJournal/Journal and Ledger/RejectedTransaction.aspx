<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="RejectedTransaction.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.RejectedTransaction" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                Rejected Transaction
            </div>
            <div id="filter" runat="server">
                  
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="startDate">Start Date: </label>
                                <div class="input-group">
                                    <asp:TextBox ID="StartDate" runat="server" CssClass="datepicker form-control" placeholder="Start Date" name="startDate"></asp:TextBox>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="endDate">End Date: </label>
                                <div class="input-group">
                                    <asp:TextBox ID="Enddate" runat="server" CssClass="datepicker form-control" placeholder="End Date" name="endDate"></asp:TextBox>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="endDate">Account Name: </label>
                                <div class="input-group">
                                    <asp:TextBox ID="accname" runat="server" CssClass="form-control" placeholder="Account Name"></asp:TextBox>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="endDate">Price: </label>
                                <div class="input-group">
                                    <asp:TextBox ID="Price" runat="server" CssClass="form-control" placeholder="Price"></asp:TextBox>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 pull-right" style="margin-bottom:20px">
                            <label style="visibility: hidden">Search</label>
                            <div class="input-group">
                                <asp:Button ID="Search" runat="server" Text="Search" OnClick="Search_Click" CssClass="btn btn-primary" />
                            </div>
                        </div>
                        <div class="row" style='height: 15px;'>
                        </div>
                    </div>
                </div>
            <div class="panel-body" style="height: 500px; overflow: auto;">
                <table class="table borderless" id="Jourtab">
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-center">Date</td>
                        <td>Account Titles and Explanation</td>
                        <td class="text-right">Ref.</td>
                        <td class="text-right">Debit</td>
                        <td class="text-right">Credit</td>
                        <td class="text-center">User</td>
                    </tr>
                    <asp:Label ID="RejTranx" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
