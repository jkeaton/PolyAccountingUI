<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="General Ledger.aspx.cs" Inherits="AccountingJournal.Journal_and_Legend.General_Ledger" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div style="text-align: center; background-color: darkblue; color: white; height: 30px; font-size: large; vertical-align: central; font-weight: bold">
        General Ledger
    </div>
    <div>
        <table style="width: 900px; margin-left: auto; margin-right: auto; border-collapse: collapse;">
            <tr>
                <td colspan="6" style="text-align: center; background-color: blue; border: solid; border-color: blue; font-weight: bolder; color: white">
                    <div style="text-align:right; height:5px;">
                        <asp:Label ID="GL_Number" runat="server"></asp:Label></div>
                    <div style="font-size:x-large">
                        <asp:Label ID="GL_Title" runat="server"></asp:Label></div>
                </td>
            </tr>
            <tr style="text-align: center; font-weight: bold; background-color: white">
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue; width:100px">Date</td>
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue; width:400px">Explanation</td>
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue">Ref.</td>
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue">Debit</td>
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue">Credit</td>
                <td style="border-bottom: solid thin; border-bottom-color: black; border-right: solid; border-right-color: blue; border-top: solid thin; border-top-color: black; border-left: solid; border-left-color: blue">Balance</td>
            </tr>
            <asp:Label ID="GL_Detail" runat="server"></asp:Label>
        </table>
    </div>
</asp:Content>
