<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="General Journal.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.General_Journal" %>

<%@ Register Assembly="AjaxControlToolkit" Namespace="AjaxControlToolkit" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                General Journal
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <div id="filter" runat="server">
                    <table>
                        <tr>
                            <td>Start Date</td>
                            <td>
                                <asp:TextBox ID="StarDat" runat="server"></asp:TextBox></td>
                            <td>
                                <asp:ImageButton ID="StCalButton" src="../Images/CalBut.png" runat="server" Width="30px" Height="30px" />
                                <asp:ScriptManager ID="asm" runat="server"></asp:ScriptManager>
                                <cc1:CalendarExtender ID="StartCald" runat="server" PopupButtonID="StCalButton"
                                    CssClass="AjaxCalendar"
                                    TargetControlID="StarDat" Format="MMMM d, yy">
                                </cc1:CalendarExtender>
                            </td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>
                                <asp:TextBox ID="EndDat" runat="server"></asp:TextBox></td>
                            <td>
                                <asp:ImageButton ID="EdCalButt" src="../Images/CalBut.png" runat="server" Width="30px" Height="30px" />
                                <cc1:CalendarExtender ID="EndCald" runat="server" PopupButtonID="EdCalButt"
                                    CssClass="AjaxCalendar"
                                    TargetControlID="EndDat" Format="MMMM d, yy">
                                </cc1:CalendarExtender>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="table borderless" id="Jourtab">
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td class="text-center">Date</td>
                        <td>Account Titles and Explanation</td>
                        <td>Ref.</td>
                        <td class="text-right">Debit</td>
                        <td class="text-right">Credit</td>
                        <td class="text-center">Posted Date</td>
                    </tr>
                    <asp:Label ID="IndJour" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
