<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="OwnerEquityState.aspx.cs" Inherits="AccountingJournal.Financial_Statement.OwnerEquityState" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                Owner's Equity Statement
                <br />
                For the Month Ended <%=Enddate.ToLongDateString() %>
            </div>
            <div class="container">
                <table class="table table-hover" style="width:600px; margin-left:auto; margin-right:auto">
                    <tr>
                        <td colspan="2">Owner's Capital,
                            <asp:Label ID="StrDat" runat="server"></asp:Label></td>
                        <td></td>
                        <td class="text-right">$
                            <asp:Label ID="StrAmt" runat="server"></asp:Label></td>
                    </tr>
                    <tr>
                        <td style="width:50px">Add:</td>
                        <td>Investments</td>
                        <td class="text-right">
                            <asp:Label ID="InvAmt" runat="server"></asp:Label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <asp:Label ID="NetLabel" runat="server"></asp:Label></td>
                        <td class="text-right">
                            <asp:Label ID="NetAmt" runat="server"></asp:Label></td>
                        <td class="text-right">
                            <asp:Label ID="AddTot" runat="server"></asp:Label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <asp:Label ID="subtotal" runat="server"></asp:Label>
                        </td>
                    </tr>
                    <tr>
                        <td>Less:</td>
                        <td>Drawing</td>
                        <td></td>
                        <td class="text-right">
                            <asp:Label ID="DrwAmt" runat="server"></asp:Label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Owner's Capital, 
                            <asp:Label ID="EndDat" runat="server"></asp:Label>
                        </td>
                        <td></td>
                        <td class="text-right">
                            <asp:Label ID="Endtot" runat="server"></asp:Label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
