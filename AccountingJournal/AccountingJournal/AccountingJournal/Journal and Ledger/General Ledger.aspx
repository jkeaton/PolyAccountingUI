<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="General Ledger.aspx.cs" Inherits="AccountingJournal.Journal_and_Legend.General_Ledger" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading ">
                General Ledger
            </div>
            <div class="panel-body" style="background-color: #e3edf5">
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <td colspan="6">
                            <div style="text-align: right; height: 5px;">
                                <asp:Label ID="GL_Number" runat="server"></asp:Label>
                            </div>
                            <div style="font-size: x-large">
                                <asp:Label ID="GL_Title" runat="server"></asp:Label>
                            </div>
                        </td>
                    </tr>
                    <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                        <td>Date</td>
                        <td class='text-left'>Description</td>
                        <td>Ref.</td>
                        <td class='text-right'>Debit</td>
                        <td class='text-right'>Credit</td>
                        <td class='text-right'>Balance</td>
                    </tr>
                    <asp:Label ID="GL_Detail" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
