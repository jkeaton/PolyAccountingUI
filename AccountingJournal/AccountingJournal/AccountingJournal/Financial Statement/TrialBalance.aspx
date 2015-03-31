<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="TrialBalance.aspx.cs" Inherits="AccountingJournal.Financial_Statement.TrialBalance" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading ">
                Trial Balance
                <br />
                <asp:Label ID="CruDate" runat="server"></asp:Label>
            </div>
            <div class="panel-body">
                <table class="table" style="width: 800px; margin-left: auto; margin-right: auto">
                    <thead>
                        <tr>
                            <th></th>
                            <th class='text-right'>Debit</th>
                            <th class='text-right'>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <asp:Label ID="T_Balance" runat="server" Text="Label"></asp:Label>
                        <tr>
                            <td></td>
                            <td>
                                <div style="text-align: Right">
                                    <asp:Label ID="TotalDeb" runat="server" Style="border-bottom: double; border-top: solid thin"></asp:Label>
                                </div>

                            </td>
                            <td>
                                <div style="text-align: right">
                                    <asp:Label ID="TotalCre" runat="server" Style="border-bottom: double; border-top: solid thin;"></asp:Label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
