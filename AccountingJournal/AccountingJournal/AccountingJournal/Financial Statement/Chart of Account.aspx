<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="Chart of Account.aspx.cs" Inherits="AccountingJournal.Financial_Statement.Chart_of_Account" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div style="text-align: center; background-color: darkblue; color: white; height: 30px; font-size: large; vertical-align: central; font-weight: bold">
        Chart of Account
    </div>
    <div>
        <table style="width: 800px; margin-left: auto; margin-right: auto">
            <tr>
                <td rowspan="2" style=" vertical-align:top">
                    <table style="width: 500px;">
                        <asp:Label ID="Asset" runat="server"></asp:Label>
                    </table>
                </td>
                <td style=" vertical-align:top">
                    <table style="width: 300px;">
                        <asp:Label ID="Lia" runat="server"></asp:Label>
                    </table>
                </td>
            </tr>
            <tr>
                <td style=" vertical-align:top">
                    <table style="width: 300px;">
                        <asp:Label ID="OEqu" runat="server"></asp:Label>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table style="width: 800px; margin-left: auto; margin-right: auto;">
            <tr>
                <td style=" vertical-align:top">
                    <table style="width: 500px;">
                        <asp:Label ID="Expe" runat="server"></asp:Label>
                    </table>
                </td>
                <td style=" vertical-align:top">
                    <table style="width: 300px;">
                        <asp:Label ID="Reve" runat="server"></asp:Label>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</asp:Content>
