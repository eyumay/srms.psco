<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $promotion_setting->getId() ?></td>
    </tr>
    <tr>
      <th>Section:</th>
      <td><?php echo $promotion_setting->getSectionId() ?></td>
    </tr>
    <tr>
      <th>Current academic year:</th>
      <td><?php echo $promotion_setting->getCurrentAcademicYear() ?></td>
    </tr>
    <tr>
      <th>Current year:</th>
      <td><?php echo $promotion_setting->getCurrentYear() ?></td>
    </tr>
    <tr>
      <th>Current semester:</th>
      <td><?php echo $promotion_setting->getCurrentSemester() ?></td>
    </tr>
    <tr>
      <th>To academic year:</th>
      <td><?php echo $promotion_setting->getToAcademicYear() ?></td>
    </tr>
    <tr>
      <th>To year:</th>
      <td><?php echo $promotion_setting->getToYear() ?></td>
    </tr>
    <tr>
      <th>To semester:</th>
      <td><?php echo $promotion_setting->getToSemester() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $promotion_setting->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $promotion_setting->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('promotionsetting/edit?id='.$promotion_setting->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('promotionsetting/index') ?>">List</a>
