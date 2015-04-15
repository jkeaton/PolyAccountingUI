<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="BalanceSheet.aspx.cs" Inherits="AccountingJournal.Financial_Statement.BalanceSheet" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Poly Accounting Information</h3>
                <h3 class="panel-title">
                    Balance Sheet
                    <br />
                    As of <asp:Label ID="CurDate" runat="server"></asp:Label>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table" style="width: 800px; margin-left: auto; margin-right: auto">
                    <thead>
                        <tr>
                            <td colspan="2" style="text-align:center; font-weight:bolder">Assets</td>
                        </tr>
                    </thead>
                    <tbody>
                        <asp:Label ID="AssetList" runat="server"></asp:Label>
                        <tr>
                            <td><div style="margin-left:40px">Total Assets</div></td>
                            <td style="text-align:right; border-top:solid thin; width:100px">
                                <asp:Label ID="TotalAssets" runat="server" Style="border-bottom: double"></asp:Label></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" style="width: 800px; margin-left: auto; margin-right: auto">
                    <thead>
                        <tr>
                            <td colspan="2" style="text-align:center; font-weight:bolder">Liabilities and Owner's Equity</td>
                        </tr>
                    </thead>
                    <tbody>
                        <asp:Label ID="LiaOWList" runat="server"></asp:Label>
                        <tr>
                            <td><div style="margin-left:40px">Total liabilities and owner's equity</div></td>
                            <td style="text-align:right; border-top:solid thin; width:100px">
                                <asp:Label ID="TotalLiaOE" runat="server" Style="border-bottom: double"></asp:Label></td>
                        </tr>
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
</asp:Content>
