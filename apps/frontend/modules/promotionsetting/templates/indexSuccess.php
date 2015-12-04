<h1>Promotion settings List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Section</th>
      <th>Current academic year</th>
      <th>Current year</th>
      <th>Current semester</th>
      <th>To academic year</th>
      <th>To year</th>
      <th>To semester</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($promotion_settings as $promotion_setting): ?>
    <tr>
      <td><a href="<?php echo url_for('promotionsetting/show?id='.$promotion_setting->getId()) ?>"><?php echo $promotion_setting->getId() ?></a></td>
      <td><?php echo $promotion_setting->getSectionId() ?></td>
      <td><?php echo $promotion_setting->getCurrentAcademicYear() ?></td>
      <td><?php echo $promotion_setting->getCurrentYear() ?></td>
      <td><?php echo $promotion_setting->getCurrentSemester() ?></td>
      <td><?php echo $promotion_setting->getToAcademicYear() ?></td>
      <td><?php echo $promotion_setting->getToYear() ?></td>
      <td><?php echo $promotion_setting->getToSemester() ?></td>
      <td><?php echo $promotion_setting->getCreatedAt() ?></td>
      <td><?php echo $promotion_setting->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('promotionsetting/new') ?>">New</a>
