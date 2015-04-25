<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="UnpostTranx.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.UnpostTranx" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                Unposted Transaction
           
            </div>
            <div class="panel-body">
<%--<div id="filter" runat="server">
                  
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
                </div>--%>
                <asp:Table class="table borderless" ID="Jourtab" runat="server">
                    <asp:TableHeaderRow ID="Table1HeaderRow"
                        BackColor="LightBlue"
                        runat="server">
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Date" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Account Titles and Explaination" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Ref." CssClass="text-right" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Debit" CssClass="text-right" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Credit" CssClass="text-right" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="Action" CssClass="text-center" />
                        <asp:TableHeaderCell
                            Scope="Column"
                            Text="TranxID" CssClass="text-center" Visible="False" />
                    </asp:TableHeaderRow>
                </asp:Table>
            </div>
        </div>
    </div>
</asp:Content>
