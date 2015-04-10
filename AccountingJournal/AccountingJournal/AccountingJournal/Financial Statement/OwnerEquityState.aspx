<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="OwnerEquityState.aspx.cs" Inherits="AccountingJournal.Financial_Statement.OwnerEquityState" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                <h3>Poly Accounting Information</h3>
                <h3 class="panel-title">Owner's Equity Statement
                <br />
                    For the Month Ended <%=Enddate.ToString("MMMM dd, yyyy") %>
                </h3>
            </div>
            <div class="container">
                <table class="table table-hover" style="width: 600px; margin-left: auto; margin-right: auto">
                    <tr>
                        <td colspan="2">Owner's Capital,
                            <asp:Label ID="StrDat" runat="server"></asp:Label></td>
                        <td></td>
                        <td style="width: 20px;"></td>
                        <td class="text-right">$
                            <asp:Label ID="StrAmt" runat="server"></asp:Label></td>
                    </tr>
                    <asp:Label ID="OEDetail" runat="server"></asp:Label>
                    <tr>
                        <td colspan="2">Owner's Capital, 
                            <asp:Label ID="EndDat" runat="server"></asp:Label>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="text-right" style="border-bottom: double">
                            <asp:Label ID="Endtot" runat="server"></asp:Label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
