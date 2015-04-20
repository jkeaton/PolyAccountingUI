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
                <%--<table class="table borderless" id="Jourtab">
                    <thead>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-center">Date</td>
                        <td>Account Titles and Explanation</td>
                        <td class="text-right">Ref.</td>
                        <td class="text-right">Debit</td>
                        <td class="text-right">Credit</td>
                        <td class="text-center">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                        <asp:Label ID="UnpostJour" runat="server"></asp:Label>
                    </tbody>
                </table>--%>
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
