<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> Detail - Admin AREA</h1>



</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <?php if (validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?=validation_errors();?>
        </div>
        <?php endif;?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PRODUK
            PENGADAAN</a>


        <?=$this->session->flashdata('message');?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama Produk</th>
                    <th scope="col" class="text-center">Gambar Produk</th>
                    <th scope="col" class="text-center">Satuan Pengadaan</th>
                    <th scope="col" class="text-center">Jumlah Pengadaan</th>
                    <th scope="col" class="text-center">Tanggal Pengadaan</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataDetailPengadaan as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td style="text-align:center;"><?=$sm['nama_produk']?></td>
                    <td style="text-align:center;"><?=$sm['gambar_produk']?></td>
                    <td style="text-align:center;"><?=$sm['satuan_pengadaan']?></td>
                    <td style="text-align:center;"><?=$sm['jumlah_pengadaan']?></td>
                    <td style="text-align:center;"><?=$sm['tanggal_pengadaan']?></td>
                    <td style="text-align:center;">
                        <a href="<?=base_url();?>admin/updatePengadaan/<?=$sm['id_pengadaan'];?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?=$sm['id_pengadaan'];?>">EDIT</a>
                        <a href="<?=base_url();?>admin/hapusPengadaan/<?=$sm['id_pengadaan'];?>"
                            class="badge badge-danger mb-3">DELETE</a>
                    </td>
                </tr>
                <?php $i++;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="#newSubMenuModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModal">Tambah Produk Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url('admin/detail_pengadaan');?>" method="post">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($dataDetailPengadaan as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_pengadaan'];?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Transaksi Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>admin/updatePengadaan/<?=$sm['id_pengadaan'];?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?=$sm['id_pengadaan'];?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="kode" name="kode"
                            value="<?=$sm['kode_pengadaan'];?>" placeholder="Kode Pengadaan" readonly>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_supplier" name="pilih_supplier">
                            <option>Pilih Supplier</option>
                            <?php foreach ($data_supplier->result() as $row) {
    if ($sm['nama_supplier'] == $row->nama_supplier) {
        echo '<option selected="selected"  value="' . $row->id_supplier . '">' . $row->nama_supplier . '</>';
    } else {
        echo '<option value="' . $row->id_supplier . '">' . $row->nama_supplier . '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="status" name="status">
                            <option value="">Pilih Status Transaksi</option>
                            <option <?php if($sm['status_pengadaan'] == 'Belum Diterima'){echo("selected");}?>>Belum
                                Diterima
                            </option>
                            <option <?php if($sm['status_pengadaan'] == 'Sudah Diterima'){echo("selected");}?>>Sudah
                                Diterima
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>