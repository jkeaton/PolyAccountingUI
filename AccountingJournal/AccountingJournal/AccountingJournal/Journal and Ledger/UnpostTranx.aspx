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
